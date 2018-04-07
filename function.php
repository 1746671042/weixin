<?php
/**
 * post请求数据
 * @param type $url
 * @param type $data
 */
function post($url, $data){
    $wxCurl = curl_init();
    //设置选项
    curl_setopt($wxCurl, CURLOPT_URL, $url);//请求的url地址
    curl_setopt($wxCurl, CURLOPT_POST, 1);//设置为post请求
    curl_setopt($wxCurl, CURLOPT_POSTFIELDS, $data);//post的参数
    curl_setopt($wxCurl, CURLOPT_SSL_VERIFYPEER, false);//https请求方式
    curl_setopt($wxCurl, CURLOPT_RETURNTRANSFER, 1);//请求的结果以字符串返回
    //发送请求
    $output = curl_exec($wxCurl);
    //释放curl句柄
    curl_close($wxCurl);
    return $output;
}

/**
 * get请求数据
 * @param type $url
 */
function get($url){
     $wxCurl = curl_init();
    //设置选项
    curl_setopt($wxCurl, CURLOPT_URL, $url);//请求的url地址
    curl_setopt($wxCurl, CURLOPT_SSL_VERIFYPEER, false);//https请求方式
    curl_setopt($wxCurl, CURLOPT_RETURNTRANSFER, 1);//请求的结果以字符串返回
    //发送请求
    $output = curl_exec($wxCurl);
    //释放curl句柄
    curl_close($wxCurl);
    return $output;
}