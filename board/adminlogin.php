<?php
//用于验证管理员密码
$array = array();
$servername = "132.232.120.208";
$username = "user";
$password = "123Jhwl@zjut";
$dbname = "severData";

$resp = file_get_contents('php://input');
$resp=json_decode($resp, true);
$command= $resp['command'];
if ($command=='yyzzs') {
    echo "True";
} else {
    echo "No";
}
