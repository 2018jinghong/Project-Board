<?php
 $array = array();
 $servername = "localhost";
 $username = "user";
 $password = "123Jhwl@zjut";
 $dbname = "severData";

 // 创建连接
 $conn = new mysqli($servername, $username, $password,$dbname);
  
 // Check connection
 if ($conn->connect_error) {
     die("连接失败: " . $conn->connect_error);
 } 

 $conn->query("set names 'utf8'");//写库
 $sql = "INSERT INTO severData.msgData(title, texts, sourceId)
         VALUES ('John', 'Doe2', 1)";
 if ($conn->query($sql) === TRUE) {
     echo "新记录插入成功";
 } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
 }
  

 $conn->close();
?>