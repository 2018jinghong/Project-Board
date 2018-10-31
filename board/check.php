<?php
function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($curl);//运行curl
        curl_close($curl);
        
        return $data;
    }

	$url = 'https://aip.baidubce.com/oauth/2.0/token';
    $post_data['grant_type']       = 'client_credentials';
    $post_data['client_id']      = 'wtDLUNvcuTfAGygEqGDc9PMQ';
    $post_data['client_secret'] = 'm5KeOPj9feTbCxDpYCsaXW7BjCxYPYoq';
    $o = "";
    foreach ( $post_data as $k => $v ) 
    {
    	$o.= "$k=" . urlencode( $v ). "&" ;
    }
    $post_data = substr($o,0,-1);
    
    $res = request_post($url, $post_data);

    var_dump($res);
    $resp=json_decode($res, true);

    $url = 'https://aip.baidubce.com/rest/2.0/antispam/v2/spam?access_token='+$resp["?access_token"];
    $post_datax['content']  = 'fuck';

    $res = request_post($url, $post_datax);
    var_dump($res);

?>