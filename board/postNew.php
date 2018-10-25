<?php
  $com = $_POST['command'];
   if($com=='post'){
   
    $data = $_POST['data'];
     echo 	$data['title'];
   }
?>