<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",options={"unsigned":true,"auto_increment":true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $detay;



    public function getDetay()
    {
        return json_decode($this->detay);
    }

    public function setDetay($detay)
    {
        $this->detay = json_encode($detay);
        return $this;
    }


}