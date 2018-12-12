<?php
namespace App\EnUygunCore\ApiClasses;

class ApiB
{

    public function getFXRatesFromAPI()
    {
        $fx = [];

        $data = json_decode(file_get_contents('http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0'),true);

        array_walk(
            $data['result'],
            function($value) use (&$fx)
            {
                switch($value['symbol'])
                {
                    case 'USDTRY':
                        $fx['dolar']    = (float) $value['amount'];
                        break;
                    case 'EURTRY':
                        $fx['euro']     = (float) $value['amount'];
                        break;
                    case 'GBPTRY':
                        $fx['sterlin']  = (float) $value['amount'];
                        break;
                    default:
                        break;
                };
            }
        );

        return $fx;
    }
}

