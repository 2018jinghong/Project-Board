<?php
$servername = "localhost";
$username = "user";
$password = "123Jhwl@zjut";
$dbname = "severData";
// 创建连接
$conn = new mysqli($servername, $username, $password);
 
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
 
$sql = "SELECT title , texts ,id,sourceId,  FROM $dbname.msgData";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo  $row["title"];
        echo  $row["texts"];
    }
} else {
    echo "0 结果";
    echo $result;
}
$conn->close();
?>