<?php 
namespace App\EnUygunCore\ApiClasses;

class ApiBAdapter  implements ApiInterface
{

    private $api_B, $fx_rates;

    public function __construct()
    {
        //$this->fx_rates = (new api_B)->getFXRatesFromAPI();

        $this->api_B = new ApiB();
        $this->fx_rates = $this->api_B->getFXRatesFromAPI();
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

}
