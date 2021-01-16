<?php
 session_start();
 //$_SESSION['keyvalue'] = "";
 //$keyvalue = $_GET['k'];
 $code = $_GET['code'];
 //echo $_SESSION['keyvalue'];
 //echo 111;
 //die;
 if(!$code){
	 header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4f3a72dab76d4d7b&redirect_uri=https%3A%2F%2Fwww.sharey-ad.com%2Fbsdc%2Fcode&response_type=code&scope=snsapi_base&state=123#wechat_redirect");
 }
    //echo $_SESSION['keyvalue'];die;
	$appid = "wx4f3a72dab76d4d7b";
	$appsecret = "b008585b765e4b74489ddb5a79b7bd22";//获取openid
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	//echo $url;
	$result = https_request($url);
	
	$jsoninfo = json_decode($result, true);
	//print_r($jsoninfo) ;
	$openid = $jsoninfo["openid"];//从返回json结果中读出openid
	$access_token = $jsoninfo["access_token"];//从返回json结果中读出openid
	$callback=$_GET['callback'];  // echo $callback."({result:'".$openid."'})";
	
	$url1 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
	//echo $url1;
	$result1 = https_request($url1);
	$jsoninfo1 = json_decode($result1, true);
	$nickname=$jsoninfo1["nickname"];
	$headimgurl=$jsoninfo1["headimgurl"];
	//echo 111;
	//print_r($result1);
	//echo $openid.":".$headimgurl.":".$nickname; //把openid 送回前端
	//die;
	if($openid){
		$_SESSION['openid'] = $openid;
		header("Location: https://www.sharey-ad.com/bsdc/index.php?openid=".$openid."&headimgurl=".$headimgurl."&nickname=".$nickname);
	}
function https_request($url,$data = null){
	$curl = curl_init();   
	curl_setopt($curl, CURLOPT_URL, $url);   
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);   
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);    
	if (!empty($data)){    
	curl_setopt($curl, CURLOPT_POST, 1);  
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);   
	}    
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($curl);    
	curl_close($curl);    
	return $output;
}
 
 //$code 		= $code;
// echo $code;
// die;
?>