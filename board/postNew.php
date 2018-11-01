<?php
function check($words)
{
    require_once 'aiSDK/AipImageCensor.php';

    // 你的 APPID AK SK
    $APP_ID = '14353274';
    $API_KEY = 'wtDLUNvcuTfAGygEqGDc9PMQ';
    $SECRET_KEY = 'm5KeOPj9feTbCxDpYCsaXW7BjCxYPYoq';

    $client = new AipImageCensor($APP_ID, $API_KEY, $SECRET_KEY);
    $result =$client->antiSpam($words);
    return  $result['result']['spam'];
}
function getIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknow";
    }
    return $ip;
}
$array = array();
///数据库信息
$servername = "localhost";
$username = "user";
$password = "123Jhwl@zjut";
$dbname = "severData";

///获取post
$resp = file_get_contents('php://input');
$resp=json_decode($resp, true);
$command= $resp['command'];

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
// $conn->query("set names 'utf8mb4'");

$data= $resp['data'];
$sourceId=(int)$data['sourceId'];

// 判断命令
if ($command=='msg') {
    $title=$data['title'];
    $text=$data['text'];
    $time=$data['time'];
    $ip=getIP();
    if (check($title)==0&&check($text)==0) {
        $sql = "INSERT INTO severData.msgData(title,texts,sourceId,timess,ip) VALUES ('$title','$text','$sourceId',$time,'$ip')";
        if ($conn->query($sql) === true) {
            echo "200 Ok";
        } else {
            echo $sql.$conn->error;
        }
    } else {
        echo "内容包括违法内容或灌水";
    }
    $conn->close();
} elseif ($command=='like') {
    $os=0;
    $sql="SELECT likes FROM severData.msgData WHERE id=$sourceId";
    $ol=$conn->query($sql);
    if ($ol->num_rows > 0) {
        // 输出数据
        while ($row = $ol->fetch_assoc()) {
            $os=(int)$row["likes"];
            $os=$os+1;
            break;
        }
    } else {
        echo $sql.$conn->error;
        exit;
    }
    $sql="UPDATE severData.msgData SET likes=$os WHERE id=$sourceId";
    if ($conn->query($sql) === true) {
        echo "200 Ok";
    } else {
        echo $sql.$conn->error;
    }
    $conn->close();
} elseif ($command=='dislike') {
    $os=0;
    $sql="SELECT dislikes FROM severData.msgData WHERE id=$sourceId";
    $ol=$conn->query($sql);
    if ($ol->num_rows > 0) {
        // 输出数据
        while ($row = $ol->fetch_assoc()) {
            $os=(int)$row["dislikes"];
            $os=$os+1;
            break;
        }
    } else {
        echo $sql.$conn->error;
        exit;
    }
    $sql="UPDATE severData.msgData SET dislikes=$os WHERE id=$sourceId";
    if ($conn->query($sql) === true) {
        echo "200 Ok";
    } else {
        echo $sql.$conn->error;
    }
    $conn->close();
} elseif ($command=='del') {
    if ($data['adminCode']=='yyzzs') {
        $sql = "DELETE FROM severData.msgData WHERE id=$sourceId";
        if ($conn->query($sql) === true) {
        } else {
            echo $sql.$conn->error;
        }
        $sql = "DELETE FROM severData.msgData WHERE sourceId=$sourceId";
        if ($conn->query($sql) === true) {
        } else {
            echo $sql.$conn->error;
        }
        echo "200 Ok";
        $conn->close();
    } else {
        echo '想破解，没门';
    }
}
