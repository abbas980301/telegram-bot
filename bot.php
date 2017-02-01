<?php
// ads_shakibonline_bot.php
require __DIR__ . '/include/autoloader.php';
require __DIR__ . '/Telegram.php';
require __DIR__ . '/include/bot.config.php';

$file_name = basename(__FILE__);
$telegram = new Telegram($API_KEY);

$chatID = $telegram->ChatID();
$time = time();

$sql = "SELECT * FROM `ads` WHERE `is_active` = 1 and `count_down` != 0";
$ads = $mysqli->query($sql);
$sql = "SELECT `count` FROM `hits` WHERE `chat_id` = '$chatID'";
$hit = $mysqli->query($sql)->fetch_assoc();

if ($ads->num_rows != 0) {

    while ($ad = $ads->fetch_assoc()) {

        $array = json_decode($ad['text'], true);
        $array['chat_id'] = $chatID;
        if (($hit['count'] - $ad['random_number']) % $ad['repeat_rate'] == 0) {
            $type = $ad['type'];
            $res = $telegram->$type($array);
            if ($res['ok'] === true) {
                $sql = "UPDATE `ads` SET `count_down` = `count_down`-1 WHERE `id` = $ad[id]; ";
                $mysqli->query($sql);
            } else {
                log_telegram_error($res, $telegram->getData(), $file_name, $array);
            }
        }

    }
}