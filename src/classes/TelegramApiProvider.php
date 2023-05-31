<?php
include("Country.php");
include("User.php");

class TelegramApiProvider
{
    public function getMessage(){

        $bottoken = '5791646930:AAH6NqZceEP-xcHnnX2mO9KcCcwKjfX3guk';

        $chat_id = 889585035;

        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        file_put_contents(__DIR__ . '/message.txt', print_r($data, true));
//        $content = file_get_contents('https://api.telegram.org/bot' . $bottoken . '/getUpdates');
//        dump($content);

//$text = $content["message"]["text"];
//в массиве хранится история сообщений бота
//        $data = json_decode($content, true);

        $n = count($data['result']);
        if (!empty( $data['result'][$n - 1]['message']['text'])) {
            $text = $data['result'][$n - 1]['message']['text'];
            if ($text === '/help') {
                $text_return = "Привет, вот команды, что я понимаю:
    /help - список команд
    /getUser - Получить данные текущего пользователя по API
    /getCountries - Получить список стран по API";
                $this->sendMessage($bottoken, $chat_id, $text_return);
            } elseif ($text === '/getUser') {
                $classUser = new User();
                $user = $classUser->getUserData();
                $text_return = "Получить данные текущего пользователя по API:
         \n id - " . $user['id'] . "\n name - " . $user["name"];
                $this->sendMessage($bottoken, $chat_id, $text_return);
            } elseif ($text === '/getCountries') {
                $classCountry = new Country();
                $countries = $classCountry->getCountries();
                $text_return = "Список стран по API:" . $countries;
                $this->sendMessage($bottoken, $chat_id, $text_return);
            } elseif ($text === '/start') {
//        $countries = getCountries();
                $text_return = "Список стран по API:";
                $this->sendMessage($bottoken, $chat_id, $text_return);
            }
        }
    }
    public function sendMessage($bottoken, $chat_id, $text, $reply_markup = '')
    {

        $postData = array(
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
            'reply_markup' => $reply_markup
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $bottoken . '/sendMessage');
        curl_setopt($curl, CURLOPT_POST, true );
        curl_setopt($curl, CURLOPT_TIMEOUT, 10 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        var_dump($status);
    }
}