<?php
require_once 'aiSDK/AipImageCensor.php';

// 你的 APPID AK SK
const APP_ID = '14353274';
const API_KEY = 'wtDLUNvcuTfAGygEqGDc9PMQ';
const SECRET_KEY = 'm5KeOPj9feTbCxDpYCsaXW7BjCxYPYoq';

$client = new AipImageCensor(APP_ID, API_KEY, SECRET_KEY);
$result =$client->antiSpam('垃圾文本');
var_dump($result);
?>