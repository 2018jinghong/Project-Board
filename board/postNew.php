<?php
$array = array();
$servername = "localhost";
$username = "user";
$password = "123Jhwl@zjut";
$dbname = "severData";

$resp = file_get_contents('php://input');
$resp=json_decode($resp,true);
$command= $resp['command'];

// 创建连接
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$conn->query("set names 'utf8'");

$data= $resp['data'];
$sourceId=(int)$data['sourceId'];

// 判断命令
if($command=='msg'){
    $title=$data['title'];
    $text=$data['text'];
    $sql = "INSERT INTO severData.msgData(title,texts,sourceId) VALUES ('$title','$text','$sourceId')";
    if ($conn->query($sql) === TRUE) {
        echo "200 Ok";
    } else {
        echo $sql.$conn->error;
    }
    $conn->close();
} 
else if($command=='like'){
    $os=0;
    $sql="SELECT likes FROM severData.msgData WHERE id=$sourceId";
    $ol=$conn->query($sql);
        if ($ol->num_rows > 0) {
            // 输出数据
            while($row = $ol->fetch_assoc()) {
                $os=(int)$row["likes"];
                $os=$os+1;
                break;
            }
        }
       
     else {
        echo $sql.$conn->error;
        exit;
    }
    $sql="UPDATE severData.msgData SET likes=$os WHERE id=$sourceId";
    if ($conn->query($sql) === TRUE) {
        echo "200 Ok";
    } else {
        echo $sql.$conn->error;
    }
    $conn->close();
} 
else if($command=='dislike') {
    $os=0;
    $sql="SELECT dislikes FROM severData.msgData WHERE id=$sourceId";
    $ol=$conn->query($sql);
        if ($ol->num_rows > 0) {
            // 输出数据
            while($row = $ol->fetch_assoc()) {
                $os=(int)$row["dislikes"];
                $os=$os+1;
                break;
            }
        }
       
     else {
        echo $sql.$conn->error;
        exit;
    }
    $sql="UPDATE severData.msgData SET dislikes=$os WHERE id=$sourceId";
    if ($conn->query($sql) === TRUE) {
        echo "200 Ok";
    } else {
        echo $sql.$conn->error;
    }
    $conn->close();
    }
else if($command=='del'){
    if($data['adminCode']=='yyzzs'){
        $sql = "DELETE FROM severData.msgData WHERE id=$sourceId";
        if ($conn->query($sql) === TRUE) {
           
        } else {
            echo $sql.$conn->error;
        }
        $sql = "DELETE FROM severData.msgData WHERE sourceId=$sourceId";
        if ($conn->query($sql) === TRUE) {
           
        } else {
            echo $sql.$conn->error;
        }
        echo "200 Ok";
        $conn->close();
     }else{
        echo '23333';
     }   
    } 

?>
