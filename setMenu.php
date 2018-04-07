<?php

header('Content-Type: text/html;charset=utf-8');
/**
 * 创建菜单
 */
$token = require_once './getToken.php';
require_once './function.php';

/**
 * 设置菜单
 * @param type $token
 */
function setMenu($token){
    $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";

    //拼接发送的参数
    $button = '{
         "button":[
         {    
              "name":"有料",
              "sub_button":[
              {
                "type":"view",
                "name":"历史消息",
                "url":"https://www.baidu.com"
              },{
                "type":"click",
                "name":"区块链课程",
                "key":"qukuailiankecheng"
              },{
                "type":"click",
                "name":"区块链专题",
                "key":"qukuailianzhuanti"
              },{
                "type":"click",
                "name":"话题文章",
                "key":"huatiwenzhang"
              }]
          },
          {
               "name":"找组织",
               "sub_button":[
               {    
                   "type":"click",
                   "name":"申请入群",
                   "key":"shenqingruqun"
                },
                {
                   "type":"click",
                   "name":"51cto学院",
                   "key":"51xueyuan"
                },
                {
                   "type":"click",
                   "name":"CTO训练营",
                   "key":"ctoxunlianying"
                },
                {
                   "type":"click",
                   "name":"WOT峰会",
                   "key":"wotfenghui"
                },
                {
                   "type":"click",
                   "name":"51CTO博客",
                   "key":"51cto博客"
                }]
           },{
               "name":"撩我",
               "sub_button":[
               {    
                   "type":"click",
                   "name":"转载&合作",
                   "key":"zhuanzaihezuo"
                },
                {
                   "type":"click",
                   "name":"官方微博",
                   "key":"guanfangweibo"
                },{
                   "type":"click",
                   "name":"技术栈",
                   "key":"jishuzhan"
                }]
           }]
     }';
    $output = post($url, $button);
    if($output != null){
        $result = json_decode($output, true);
        if($result["errcode"] ==0){
            echo "设置成功";
        }else{
            var_dump($result["errcode"] );
            echo "设置失败";
        }
    }else{
        echo "设置失败";
    }
}

/**
 * 获取菜单
 */
function getMenu($token){
    $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$token}";
    //发送请求
    $data = get($url);
    var_dump($data);
}
//getMenu($token);
/**
 * 删除菜单
 */
function delMenu($token){
    $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$token}";
    $data = get($url);
    var_dump(json_decode($data, true));
}
setMenu($token);

