<?php 
namespace App\EnUygunCore\ApiClasses;

class ApiA  implements ApiInterface
{

    private $fx_rates, $api_url;

    public function __construct()
    {
        $this->api_url = 'http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3';
        $this->fx_rates = $this->getFXDataFromAPI();
    }

    public function getDolar()
    {
        return $this->fx_rates['dolar'];
    }

    public function getEuro()
    {
        return $this->fx_rates['euro'];
    }

    public function getSterlin()
    {
        return $this->fx_rates['sterlin'];
    }

    private function getFXDataFromAPI()
    {
        $fx = [];
        $data = json_decode(file_get_contents($this->api_url),true);

        array_walk($data, function($value) use (&$fx)
        {
            switch($value['kod'])
            {
                case 'DOLAR':
                    $fx['dolar'] = (float) $value['oran'];
                    break;
                case 'AVRO':
                    $fx['euro'] = (float) $value['oran'];
                    break;
                case 'İNGİLİZ STERLİNİ':
                    $fx['sterlin'] = (float) $value['oran'];
                    break;
                default:
                    break;
            };
        });

        return $fx;
    }

}
