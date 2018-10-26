<?php
$array = array();
$servername = "localhost";
$username = "user";
$password = "123Jhwl@zjut";
$dbname = "severData";

$resp = file_get_contents('php://input'); 
$resp=json_decode($resp,true);
$com= $resp['command']; 
if($com=='post'){
  $data= $resp['data']; 
  $title=$data['title'];
  $text=$data['text'];
  $sourceId=(int)$data['sourceId'];
     // 创建连接
     $conn = new mysqli($servername, $username, $password,$dbname);
     // Check connection
     if ($conn->connect_error) {
         die("连接失败: " . $conn->connect_error);
     } 
     $conn->query("set names 'utf8'");//写库
     $sql = "INSERT INTO severData.msgData(title,texts,sourceId)
             VALUES ('$title','$text','$sourceId')";
     if ($conn->query($sql) === TRUE) {
       echo "200 Ok";
     } else {
        echo $sql.$conn->error;
     }
     $conn->close();

    }
    else 
    {
      $data= $resp['data']; 
      $id=(int)$data['sourceId'];
       // 创建连接
     $conn = new mysqli($servername, $username, $password,$dbname);
     // Check connection
     if ($conn->connect_error) {
         die("连接失败: " . $conn->connect_error);
     } 
     $conn->query("set names 'utf8'");//写库
     
    if($com=='like'){
      $os=0;
      $ol=$conn->query("SELECT likes FROM severData.msgData WHERE id='$id'");
      if ($ol->num_rows > 0) {
        // 输出数据
        while($row = $ol->fetch_assoc()) {          
            $os=(int)$row["likes"];
            $os=$os+1;
            echo $os;
            break;
        }
    } else {
       
       exit; 
    }
      $result =   $conn->query("UPDATE severData.msgData SET likes='$os' WHERE id='$id'");//写库
    }else{
      $os=0;
      $ol=$conn->query("SELECT dislikes FROM severData.msgData WHERE id='$id'");
      if ($ol->num_rows > 0) {
        // 输出数据
        while($row = $ol->fetch_assoc()) {          
            $os=(int)$row["likes"];
            $os=$os+1;
            echo $os;
            break;
        }
    } else {
       
       exit; 
    }
      $result =   $conn->query("UPDATE severData.msgData SET disklikes='$os' WHERE id='$id'");//写库

    }
      if ($conn->query($sql) === TRUE) {
        echo "200 Ok";
      } else {
         echo $sql.$conn->error;
      }

    }

  


?>