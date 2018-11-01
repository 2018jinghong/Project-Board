<?php
header("Content-type: text/html;charset=utf-8");
class msg
{
    public $title = 'this is public';
    public $text='text';
    public $id = 1;
    public $sourceId=0;
    public $time = 32457689;
    public $userIp='text';
    public $like=123;
    public $dislike=2;
}
class response
{
    public static function show($code, $message, $type='json')
    {
        if ($_REQUEST['id']!=0) {
            $array = array();
            $servername = "132.232.120.208;
            $username = "user";
            $password = "123Jhwl@zjut";
            $dbname = "severData";
            $id=(int)$_REQUEST['id'];
            // 创建连接
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("连接失败: " . $conn->connect_error);
            }
            // mysql_query("set character set 'utf8'");//读库
            // $conn->query("set names 'utf8'");//写库

            $result =   $conn->query("SELECT title,id,texts,sourceId,likes,dislikes FROM severData.msgData WHERE id=$id");//写库
            if ($result->num_rows > 0) {
                // 输出数据
                while ($row = $result->fetch_assoc()) {
                    $ms=new msg;
                    $ms->id=(int)$row["id"];
                    $ms->title=$row["title"];
                    $ms->text=$row["texts"];
                    $ms->sourceId=(int)$row["sourceId"];
                    $ms->like=(int)$row["likes"];
                    $ms->dislike=(int)$row["dislikes"];
                    array_push($array, $ms);
                }
                $foo_json = json_encode($array);
                echo $foo_json;
            } else {
                echo "0 结果";
                echo $result;
            }
            $conn->close();
            exit;
        }
    }
}

response::show(200, 'success', 'json');
