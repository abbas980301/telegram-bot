<?php
require __DIR__ . '/include/autoloader.php';
require __DIR__ . '/Telegram.php';

$base_url = $_SERVER['HTTP_REFERER'];


$token = 'TOKEN_HERE';   // @tempDamBot
$url = $base_url . 'PATH_TO_PHP_FILE';
$telegram = new Telegram($token);
$telegram->setWebhook($url);
