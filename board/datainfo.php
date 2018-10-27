<?php 
header("Content-type: text/html;charset=utf-8");

function compare_rule($x,$y){         //排序规则为按id倒序
    if($x->id==$y->id) return 0;
    return ($x->id>$y->id)?-1:1;
}

class msg {
public    $title = 'this is public';
public    $text='text';
public    $id = 1;
public    $sourceId=0;
public    $time = 32457689;
public    $userIp='text';
public    $like=0;
public    $dislike=0;
}

class response{
    public static function show($code,$message,$type='json'){
        if($_REQUEST['page']==0){
            //为0 返回基本信息
            $result=array(
                "allPages"=>2,
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
       // mysql_query("set character set 'utf8'");//读库 
        $conn->query("set names 'utf8'");//写库
        $sql = "SELECT title, texts ,id,sourceId,likes,dislikes FROM $dbname.msgData ORDER BY id ASC";
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
                
        // uasort($array,'compare_rule'); //排序

        $foo_json = json_encode($array);
        echo $foo_json;
    }   
}
response::show(200,'success','json');
?>