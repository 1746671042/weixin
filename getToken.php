<?php

/**
 * 获取access_token
 */
$appid = "wx79a6e79cedbd3ca4";
$appsecret = "67a96f6b2804d9515fa75050a1bf8a7b";

//实例化redis
$redis = new Redis();
//连接
$redis->connect('127.0.0.1', 6379);

$tokenList = $redis->zrange('token', 0, -1); 
$token = isset($tokenList[2])?$tokenList[2]: "";
//判断是否重新获取
if($tokenList == null || $tokenList[0]+$tokenList[1]/2 < time()){
    //获取token的请求地址
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
    //发送请求
    //发送请求给微信服务器采用curl方式
    //初始化
    $wxCurl = curl_init();
    //设置选项
    curl_setopt($wxCurl, CURLOPT_URL, $url);//请求的url地址
    curl_setopt($wxCurl, CURLOPT_SSL_VERIFYPEER, false);//https请求方式
    curl_setopt($wxCurl, CURLOPT_RETURNTRANSFER, 1);//请求的结果以字符串返回
    //发送请求
    $output = curl_exec($wxCurl);
    //释放curl句柄
    curl_close($wxCurl);

    if($output != null){
        $result = json_decode($output, true);
        if(isset($result["access_token"])){
            $token = $result["access_token"];
            $expire = $result["expires_in"];
            //存储
        //    1.永久的redis(token，expire，start_time)
                $redis->del('token');
                $redis->zAdd("token","value", $token);
                $redis->zAdd("token","expire", $expire);
                $redis->zAdd("token","time", time());
        }
    }

}
return $token;


