<?php



class Country
{
    public function getCountries()
    {
        $apiToken = "f2821815a1934aadc2af92ba879348d9";

        $url = "http://api.leads.su/webmaster/geo/getCountries?token=" . $apiToken;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $responce = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $lastError = curl_error($curl);
        curl_close($curl);

        $result = json_decode($responce, true);
//dump($result);


        $countries = array();
        foreach ($result['data'] as $res) {
//    var_dump($res);
            $countries[] = $res['name'];
        }
//var_dump($countries);

        rsort($countries);

        $outputCountries = array_slice($countries, 0, 10);
//$str = implode(', ', $outputCountries);
//dump($str);
        return implode(', ', $outputCountries);
    }
}