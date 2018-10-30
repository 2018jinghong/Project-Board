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
    public $like=0;
    public $dislike=0;
}

function show($code, $message, $type='json')
{
    if ($_REQUEST['page']==0) {
        //为0 返回基本信息
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
        $os=0;
        $sql="SELECT COUNT(*) FROM severData.msgData WHERE sourceId=0";
        $ol=$conn->query($sql);
        if ($ol->num_rows > 0) {
            // 输出数据
            while ($row = $ol->fetch_assoc()) {
                $os=(int)$row["COUNT(*)"];
                break;
            }
        } else {
            echo $sql.$conn->error;
            exit;
        }
        $conn->close();
        $result=array(
            "allPages"=>(int)(($os-1)/10)+1,
        );
        echo json_encode($result);
    } else {
        json();
    }
}
function json()
{
    $page=(int)$_REQUEST['page'];

    $servername = "localhost";
    $username = "user";
    $password = "123Jhwl@zjut";
    $dbname = "severData";
    $array = array();
    // 创建连接
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    // mysql_query("set character set 'utf8'");//读库
    $conn->query("set names 'utf8'");//写库

    $os=0;
    $sql="SELECT COUNT(*) FROM severData.msgData WHERE sourceId=0";
    $ol=$conn->query($sql);
    if ($ol->num_rows > 0) {
        // 输出数据
        while ($row = $ol->fetch_assoc()) {
            $os=(int)$row["COUNT(*)"];
            break;
        }
    } else {
        echo $sql.$conn->error;
        exit;
    }

    $left=($page-1)*10;
    $right=$left+10;

    $sql = "SELECT title, texts ,id,sourceId,likes,dislikes,timess FROM $dbname.msgData Where sourceId=0 ORDER BY id desc limit $left,$right ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // 输出数据
        $bsd = array();
        while ($row = $result->fetch_assoc()) {
            $ms=new msg;
            $ms->id=(int)$row["id"];
            $ms->title=$row["title"];
            $ms->text=$row["texts"];
            $ms->sourceId=(int)$row["sourceId"];
            $ms->like=(int)$row["likes"];
            $ms->dislike=(int)$row["dislikes"];
            $ms->time=(int)$row["timess"];
            array_push($array, $ms);
            if (!in_array($ms->id, $bsd)) {
                array_push($bsd, $ms->id);
            }
        }
    } else {
        echo $result;
    }
    for ($i=0;$i<count($bsd);$i++) {
        $sql = "SELECT title, texts ,id,sourceId,likes,dislikes,timess FROM $dbname.msgData Where sourceId=$bsd[$i]  ORDER BY id desc ";
        $result2= $conn->query($sql);
        if ($result2->num_rows > 0) {
            // 输出数据
            while ($row2 = $result2->fetch_assoc()) {
                $ms2=new msg;
                $ms2->id=(int)$row2["id"];
                $ms2->title=$row2["title"];
                $ms2->text=$row2["texts"];
                $ms2->sourceId=(int)$row2["sourceId"];
                $ms2->like=(int)$row2["likes"];
                $ms2->dislike=(int)$row2["dislikes"];
                $ms2->time=(int)$row2["timess"];
                array_push($array, $ms2);
                if (! in_array($ms2->id, $bsd)) {
                    array_push($bsd, $ms2->id);
                }
            }
        }
    }



    $conn->close();
    $foo_json = json_encode($array);
    echo $foo_json;
}

show(200, 'success', 'json');
