<?php
//include('vendor/autoload.php'); //Подключаем библиотеку
//use Telegram\Bot\Api;

function dump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}


include('classes/TelegramApiProvider.php');


$class = new TelegramApiProvider();
$class->getMessage();




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

//$token = "6143340979:AAFxnTSm3Dv2XvXV2qtP-BYU7DQS79tQHWE";
//
//$textMessage = "Тестовое сообщение";
//$textMessage = urlencode($textMessage);
//
//$urlQuery = "https://api.telegram.org/bot". $token ."/sendMessage?chat_id=". $chat_id ."&text=" . $textMessage;
//
//$result = file_get_contents($urlQuery);
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

