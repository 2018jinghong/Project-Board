<?php 
class response{
    public static function show($code,$message,$data=array(),$type='json'){
        /**
        *按综合方式输出通信数据
        *@param integer $code 状态码
        *@param string $message 提示信息
        *@param array $data 数据
        *@param string $type 数据类型
        *return string
        */
        if($_REQUEST['id']!=0)
        {
            $result=array(
                "Title"=>"大家好",           
                "id"=>$_REQUEST['id'],
            );
            echo json_encode($result);
            exit;
        }
        if($_REQUEST['page']==0){

            $result=array(
                "AllPages"=>5,
                "Uesr_ip"=>array("Hello World","JS"),  
            );
            echo json_encode($result);
            exit;
        }
       
        if(!is_numeric($code)){
            return '';
        }
      
        if($type=='json'){
            self::json($code,$message,$data);
            exit;
        }elseif($type=='xml'){
            self::xmlEncode($code,$message,$data);
            exit;
        }else{
            //后续添加其他格式的数据
        }

     
       
    }
    //按json格式返回数据
    public static function json($code,$message,$data=array()){
        if(!is_numeric($_REQUEST['page'])){
            return '';
        }
        

        if($_REQUEST['page']==1){
            $result=array(
                "Title"=>array("大家好","那么好","tes","ds","那么好"),
                "text"=>array("Hello World","JS","Hello World","JS","JS"),
                "id"=>array(12,7,9,5,8),
                "source_id"=>array(0,12,12,7,7),
                "user_ip"=>array("10.0.0.9","10.19.12.1","10.19.12.1","10.19.12.1","10.19.12.1"),
                "like"=>array(10086,1113,8,7,0),
                "dislike"=>array(98,2,5,55,0),
                "time"=>array(32457689,1232434,5,56645,9989898),
                "count"=>5
            );
            echo json_encode($result);
        }else{
            $result=array(
                "Title"=>array("大好","那好"),
                "text"=>array("Hello World","JS"),
                "source_id"=>array(0,0),
                "id"=>array(1,70),
                "user_ip"=>array("10.0.0.9","10.19.12.1"),
                "like"=>array(10086,1113),
                "dislike"=>array(98,0),
                "time"=>array(32457689,1232434),
                "count"=>2
            );
            echo json_encode($result); 
        }
        
    }
    //按xml格式返回数据
    public static function xmlEncode($code,$message,$data=array()){
        if(!is_numeric($code)){
            return '';
        }
        $result=array(
            "Title"=>array("大家好","那么好"),
            "text"=>array("Hello World","JS"),
            "source_id"=>array(0,0),
            "user_ip"=>array("10.0.0.9","10.19.12.1"),
            "like"=>array(10086,1113),
            "dislike"=>array(98,0),
            "time"=>array(32457689,1232434),
            "count"=>2
        );
        header("Content-Type:text/xml");
        $xml="<?xml version='1.0' encoding='UTF-8'?>";
        $xml.="<root>";
        $xml.=self::xmlToEncode($result);
        $xml.="</root>";
        echo $xml;
    }
    public static function xmlToEncode($data){
        $xml=$attr='';
        foreach($data as $key=>$value){
            if(is_numeric($key)){
                $attr="id='{$key}'";
                $key="item";
            }
            $xml.="<{$key} {$attr}>";
            $xml.=is_array($value)?self::xmlToEncode($value):$value;
            $xml.="</{$key}>";
        }
        return $xml;
    }
}
$data=array(1,231,123465,array(9,8,'pan'));
response::show(200,'success',$data,'json');
?>
