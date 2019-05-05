<?php
require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'YOUR-ACCESS-TOKEN';
$channelSecret = 'YOUR-CHANNEL-SECRET';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId     = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp    = $client->parseEvents()[0]['timestamp'];
$type         = $client->parseEvents()[0]['type'];

$message     = $client->parseEvents()[0]['message'];
$messageid     = $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0]; # /shalat bandung
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Function]-------------------------# # 
function sederhana($keyword)
{
    $belajar = "HELLO WORLD\n";
    $belajar .= "<br>";
    $belajar .= " HELLO";
    return $belajar;
}
function sederhana1($keyword)
{
    $result = "HELLO PETTER";
    return $result;
}
#-------------------------[Function]-------------------------#

//show menu, saat join dan command /menu
if ($type == 'join' || $command == '/menu') {
    $text = "INI PESAN PEMBUKA, SILAHKAN KAMU EDIT SENDIRI SESUKA HATI KALIAN";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}

//pesan bergambar
if ($message['type'] == 'text') {
    if ($command == 'yes') {

        $result = sederhana($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => str_replace("HELLO", "HAI", $result),
                )
            )
        );
    }
}
if (isset($balas)) {
    $result = json_encode($balas);
    //$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}