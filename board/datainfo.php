<?php 
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
class response{
    public static function show($code,$message,$data=array(),$type='json'){
        if($_REQUEST['id']!=0)
        {
            $result=array(
                "title"=>"test",           
                "id"=>$_REQUEST['id'],
            );
            echo json_encode($result);
            exit;
        }
        if($_REQUEST['page']==0){

            $result=array(
                "allPages"=>5,
                "uesrIp"=>array("Hello World","JS"),  
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
        
        if($_REQUEST['page']==1){

		$array = array();
        for($i = 1; $i < 20; $i++) {
            $ms=new msg;
            $ms->id=$i;
            array_push($array, $ms);
        }
        $foo_json = json_encode($array);
        echo $foo_json;

        }else{

        }
        
    }
  
    
}
$data=array(1,231,123465,array(9,8,'pan'));
response::show(200,'success',$data,'json');
?>