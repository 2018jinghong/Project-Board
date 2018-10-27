<?php 
header("Content-type: text/html;charset=utf-8");
class msg {
public    $title = 'this is public';
public    $text='text';
public    $id = 1;
public    $sourceId=0;
public    $time = 32457689;
public    $userIp='text';
public    $like=123;
public    $dislike=2;
}
$servername = "localhost";
$username = "user";
$password = "123Jhwl@zjut";
$dbname = "severData";

class response{
    public static function show($code,$message,$type='json'){
        if($_REQUEST['page']==0){
  // 创建连接
  $conn = new mysqli($servername, $username, $password);
         
  // Check connection
  if ($conn->connect_error) {
      die("连接失败: " . $conn->connect_error);
  } 
  $conn->query("set names 'utf8'");//写库
  $sql = "SELECT COUNT(*) as total FROM  $dbname.msgData";
  $os=1;
  $res = $conn->query($sql);
  if ($res->num_rows > 0) {
    // 输出数据
    while($row = $res->fetch_assoc()) {          
        $os=(int)$row["total"];
        break;
    }
  $conn->close();
  $result=array(
                "allPages"=>$os/20,
            );
            echo json_encode($result);
            exit;
        }
       
        if(!is_numeric($code)){
            return '';
        }
      
        if($type=='json'){
            self::json($code,$message,$data);
        }
    }

    public static function json($code,$message,$data=array()){
        if(!is_numeric($_REQUEST['page'])){
            return '';
        }
        $array = array();
       
     
        // 创建连接
        $conn = new mysqli($servername, $username, $password);
         
        // Check connection
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } 
       // mysql_query("set character set 'utf8'");//读库 
        $conn->query("set names 'utf8'");//写库
        $sql = "SELECT title, texts ,id,sourceId,likes,dislikes FROM $dbname.msgData";
        $result = $conn->query($sql);
         
        if ($result->num_rows > 0) {
            // 输出数据
            while($row = $result->fetch_assoc()) {
                $ms=new msg;
                $ms->id=(int)$row["id"];
                $ms->title=$row["title"];
                $ms->text=$row["texts"];
                $ms->sourceId=(int)$row["sourceId"];
                $ms->like=(int)$row["likes"];
                $ms->dislike=(int)$row["dislikes"];
                array_push($array, $ms);       
            }
        } else {
            echo "0 结果";
            echo $result;
        }
        $conn->close();
        
        $foo_json = json_encode($array);
        echo $foo_json;

       
        
    }
  
    
}


response::show(200,'success','json');
?>