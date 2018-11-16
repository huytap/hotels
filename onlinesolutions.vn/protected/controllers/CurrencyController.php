<?php
class CurrencyController extends Controller{
    public function actionIndex() {
        if ($file = file_get_contents('http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx')) {
            $url = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);
            curl_close($ch);
            $exchange_rates = array();
            $exchange = array();
            if ($json !== '' && preg_match_all('/Exrate CurrencyCode="(.*)" CurrencyName="(.*)" Buy="(.*)" Transfer="(.*)" Sell="(.*)"/', $json, $matches) && count($matches) > 0 && preg_match_all("/<DateTime>(.*)<\/DateTime>/", $json)) {
                $exchange_rates['rates'] = array(
                    'USD' => array(), //1
                    'EUR' => array(), //2
                    'GBP' => array(), //3
                    'HKD' => array(), //4
                    'JPY' => array(), //5
                    'CHF' => array(), //6
                    'AUD' => array(), //7
                    'CAD' => array(), //8
                    'SGD' => array(), //9
                    'THB' => array(), //10
                    'DKK' => array(), //11
                    'INR' => array(), //12
                    'KRW' => array(), //13
                    'MYR' => array(), //14
                    'KWD' => array(), //15
                    'NOK' => array(), //16
                    'RUB' => array(), //17
                    'SAR' => array(), //18
                    'SEK' => array(), //19
                    'VND' => array()//20
                );
                foreach ($matches[1] as $key => $value) {
                    if (isset($exchange_rates['rates'][$value])) {
                        $exchange[$value] = array(
                            'id' => $value,
                            'name' => $matches[2][$key],
                            'buy' => $matches[3][$key],
                            'transfer' => $matches[4][$key],
                            'sell' => $matches[5][$key]
                        );
                    }
                }
                $exchange['VND'] = array(
                    'id' => 'VND',
                    'name' => 'VIET NAM DONG',
                    'buy' => 1, //$exchange_rates['rates']['USD']['buy'],
                    'transfer' => 1, // $exchange_rates['rates']['USD']['sell'],
                    'sell' => 1//$exchange_rates['rates']['USD']['sell']
                );
                //the_date, exchange_rate, original_xml

                $now = date('Y-m-d');
                $model = new ExchangeRate;
                $model->the_date = $now;
                $model->exchange_rate = json_encode($exchange);
                $model->original_xml = $file;
                
                if ($model->save()) {               
                    echo 'Get data successfully';
                    die;
                }
            }
            die;
        }
    }
}