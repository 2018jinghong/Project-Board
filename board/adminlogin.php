<?php
$array = array();
$servername = "localhost";
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
