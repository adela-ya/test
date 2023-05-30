<?php
//include('vendor/autoload.php'); //Подключаем библиотеку
//use Telegram\Bot\Api;

function dump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

//$token = "6143340979:AAFxnTSm3Dv2XvXV2qtP-BYU7DQS79tQHWE";
$chat_id = -946151414;
//
//$textMessage = "Тестовое сообщение";
//$textMessage = urlencode($textMessage);
//
//$urlQuery = "https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $chat_id ."&text=" . $textMessage;
//
//$result = file_get_contents($urlQuery);
//

$token = "6143340979:AAFxnTSm3Dv2XvXV2qtP-BYU7DQS79tQHWE";
//
//$getQuery = array(
//    "chat_id" 	=> -946151414,
//    "text"  	=> "Новое сообщение из формы",
//    "parse_mode" => "html",
//);
//$ch = curl_init("https://api.telegram.org/bot". $token ."/sendMessage?" . http_build_query($getQuery));
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_HEADER, false);
//
//$resultQuery = curl_exec($ch);
//curl_close($ch);

//echo $resultQuery;
$bottoken = '6143340979:AAFxnTSm3Dv2XvXV2qtP-BYU7DQS79tQHWE';

$content = file_get_contents('https://api.telegram.org/bot' . $bottoken . '/getUpdates');
dump($content);

//$text = $content["message"]["text"];
//в массиве хранится история сообщений бота
$data = json_decode($content, true);
//выясняем размер массива – количество сообщений
$n = count($data['result']);
//получаем текст последнего
$text = $data['result'][$n - 1]['message']['text'];

//var_dump($text);


//$url="https://api.telegram.org/bot" . $bottoken . "/";
//$button_yes = array('text' => 'Согласен', 'callback_data' => '/yes_call');
//$button_no = array('text' => 'не согласен', 'callback_data' => '/no_call');
//$keyboard = array('inline_keyboard' => array(array($button_yes, $button_no)));
//$params['reply_markup'] = json_encode($keyboard, TRUE);
//$con = curl_init();
//$msg=$url."sendMessage?chat_id=".$chat_id."&text=Hello&reply_markup=".$params['reply_markup'];
//curl_setopt($con, CURLOPT_URL, $msg);
//curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($con, CURLOPT_HEADER, 0);
//$output = curl_exec($con);
//

if (!empty($text)) {
//    $text_array = explode(" ", $text);

    // получим текущее состояние бота, если оно есть
//    $bot_state = get_bot_state ($chat_id);

    // если текущее состояние бота отправка заявки, то отправим заявку менеджеру компании на $order_chat_id


    // вывод информации Помощь
    if ($text === '/help') {
        $text_return = "Привет, вот команды, что я понимаю:
    /help - список команд
    /getUser - Получить данные текущего пользователя по API
    /getCountries - Получить список стран по API";
        message_to_telegram($bottoken, $chat_id, $text_return);
    }
    elseif ($text === '/getUser') {
        $user = getUserData();
        $text_return = "Получить данные текущего пользователя по API:
         \n id - ". $user['id']. "\n name - " . $user["name"];

        message_to_telegram($bottoken, $chat_id, $text_return);
    }
    elseif ($text === '/getCountries') {
        $countries = getCountries();
        $text_return = "Список стран по API:" . $countries;
        message_to_telegram($bottoken, $chat_id, $text_return);
    }
}
 function message_to_telegram($bottoken, $chat_id, $text, $reply_markup = '')
{
    $ch = curl_init();
    $ch_post = [
        CURLOPT_URL => 'https://api.telegram.org/bot' . $bottoken . '/sendMessage',
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => [
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => $text,
            'reply_markup' => $reply_markup,
        ]
    ];

    curl_setopt_array($ch, $ch_post);
    curl_exec($ch);
}



function getCountries(){
    $apiToken = "f2821815a1934aadc2af92ba879348d9";

    $url      =  "http://api.leads.su/webmaster/geo/getCountries?token=". $apiToken;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $url);

    $responce = curl_exec($curl);

    $status    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
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

function getUserData() {
    $apiToken = "f2821815a1934aadc2af92ba879348d9";


    $url = "http://api.leads.su/webmaster/account?token=" . $apiToken;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_URL, $url);

    $responce = curl_exec($curl);

    $status    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $lastError = curl_error($curl);
    curl_close($curl);

    $result = json_decode($responce, true);

    $userData = array(
        "id"   => $result['data']['id'],
        "name" => $result['data']['name']
    );

//var_dump($userData);
    return $userData;

}