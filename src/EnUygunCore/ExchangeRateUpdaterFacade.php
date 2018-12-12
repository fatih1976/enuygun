<?php

namespace App\EnUygunCore;


use Symfony\Component\ClassLoader\ClassMapGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;

//use ReflectionClass;
use App\Entity\Currency;



class ExchangeRateUpdaterFacade
{

    private $exchange_rates, $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function updateExchangeRate()
    {
        //FX stands for Foreign Exchange
        return $this
            ->setEmptyFXData()
            ->getLatestFXDataFromAPIClasses()
            ->saveExchangeRates()
            ->returnResult();
    }

    /**
     *  ApiClasses klasorune bakar ve ApiInterface implement eden class veya
     * adapter classlari 'aktif' olarak algilar var onlardan FX degerleri
     * cekmelerini ister. Yeni bir API eklemek icin bir api class
     * olusturup, ApiInterface ile implement etmek yeterlidir.
     *
     * @return $this
     */
    private function getLatestFXDataFromAPIClasses()
    {
        $possible_classes = ClassMapGenerator::createMap(__DIR__.'/ApiClasses');
        foreach ($possible_classes AS $class_definition => $class_file)
        {

            //$class = new ReflectionClass($k);
            //if ($class->implementsInterface('App\EnUygunCore\ApiClasses\ApiInterface') && !$class->isInterface())

            if(in_array('App\EnUygunCore\ApiClasses\ApiInterface', class_implements($class_definition)))
            {
                $api =  new $class_definition();

                foreach($this->exchange_rates AS $curreny_name => &$currency_value)
                {

                    $this->setMinimumFXValue
                    (
                        $currency_value,
                        call_user_func(array($api, 'get'.ucwords($curreny_name)))
                    );

                }

            }

        }
        return $this;
    }

    /**
     * iki deger alir ve karsilastirir, kucuk olani bulup
     * buldugu degeri REFERANS olarak aldigi
     * ilk parametrenin uzerine yazar
     *
     * @param $local_value
     * @param $api_value
     */
    private function setMinimumFXValue(&$local_value, $api_value)
    {
        $local_value = empty($local_value)
            ? $api_value
            : min($local_value, $api_value);
        return;
    }

    /**
     * en son parite bilgilerini veritabanina yazar
     * @return $this
     */
    private function saveExchangeRates()
    {
        $entityManager = $this->container->get('doctrine')->getEntityManager();
        $currency = new Currency();
        $currency->setDetay($this->exchange_rates);
        $entityManager->persist($currency);
        $entityManager->flush();
        return $this;
    }

    /**
     * basarili ise success, degil
     * ise hatayi yazar
     * @return string
     */
    private function returnResult()
    {
        return 'Success!';
    }

    private function setEmptyFXData()
    {
        $this->exchange_rates = [
            'dolar'     => 0.00,
            'euro'      => 0.00,
            'sterlin'   => 0.00
        ];
        return $this;
    }

}