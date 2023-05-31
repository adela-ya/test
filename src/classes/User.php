<?php


class User
{
    public function getUserData()
    {
        $apiToken = "f2821815a1934aadc2af92ba879348d9";


        $url = "http://api.leads.su/webmaster/account?token=" . $apiToken;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_URL, $url);

        $responce = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $lastError = curl_error($curl);
        curl_close($curl);

        $result = json_decode($responce, true);

        $userData = array(
            "id" => $result['data']['id'],
            "name" => $result['data']['name']
        );

//var_dump($userData);
        return $userData;

    }
}