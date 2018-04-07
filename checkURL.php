<?php
if(isset($_GET["echostr"])){//校验
//保证页面中只有最后返回的信息，不存在其他任何东西
    header('Content-Type: text/plain');
    //获取参数
    $signature = $_GET["signature"];
    $time = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $str = $_GET["echostr"];

    //和填写配置中的token一致
    $token = "sdfsafsdafsafdgfg";
    //加密
    $tmpArr = array($token, $time, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );//加密成功的值
    //校验
    if($tmpStr == $signature){
        echo $str;
    }else{
        echo false;
    }
}else{//消息接收和回复消息
    $postData = $GLOBALS["HTTP_RAW_POST_DATA"];//xml格式
    file_put_contents("2.txt", $postData);
    $msg = simplexml_load_string($postData);//对象
    $msgType = $msg->MsgType;
    $toUserName = $msg->ToUserName;//开发者的微信号
    $fromUserName = $msg->FromUserName;//用户的openid
    $time = time();
    $count = 0;
   
    //图片消息的回复
//    $str = <<<xml
//            <xml>
//                <ToUserName><![CDATA[$fromUserName]]></ToUserName>
//                <FromUserName><![CDATA[$toUserName]]></FromUserName>
//                <CreateTime>$time</CreateTime>
//                <MsgType><![CDATA[image]]></MsgType>
//                <Image><MediaId><![CDATA[BE5ztMJWFKcAkV_TWzIk5u7RkzC51rXB_0rIKKbxaaMsxvy_mjiaZf0d4xxbtC59]]></MediaId></Image>
//            </xml>
//xml;
//    echo $str;
    
    //回复图文消息
//    $str = <<<xml
//            <xml>
//                <ToUserName><![CDATA[$fromUserName]]></ToUserName>
//                <FromUserName><![CDATA[$toUserName]]></FromUserName>
//                <CreateTime>$time</CreateTime>
//                <MsgType><![CDATA[news]]></MsgType>
//                <ArticleCount>3</ArticleCount>
//                <Articles>
//                    <item>
//                        <Title><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Title>
//                        <Description><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Description>
//                        <PicUrl><![CDATA[http://inews.gtimg.com/newsapp_ls/0/3202087085_150120/0]]></PicUrl>
//                        <Url><![CDATA[https://news.qq.com/a/20180407/000499.htm]]></Url>
//                    </item>
//                    <item>
//                        <Title><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Title>
//                        <Description><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Description>
//                        <PicUrl><![CDATA[http://inews.gtimg.com/newsapp_ls/0/3202087085_150120/0]]></PicUrl>
//                        <Url><![CDATA[https://news.qq.com/a/20180407/000499.htm]]></Url>
//                    </item>
//                    <item>
//                        <Title><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Title>
//                        <Description><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Description>
//                        <PicUrl><![CDATA[http://inews.gtimg.com/newsapp_ls/0/3202087085_150120/0]]></PicUrl>
//                        <Url><![CDATA[https://news.qq.com/a/20180407/000499.htm]]></Url>
//                    </item>
//                </Articles>
//            </xml>  
//xml;
    switch ($msgType){
        case "text"://文本消息
            $content = $msg->Content;
            switch ($content){
                case "你好":case "您好":
                    $replayContent = "您好";
                    break;
                default :
                    $replayContent = "您发送的内容不能识别";
                    break;
            }
            //回复文本消息
            $str = <<<xml
        <xml>
            <ToUserName><![CDATA[$fromUserName]]></ToUserName>
            <FromUserName><![CDATA[$toUserName]]></FromUserName>
            <CreateTime>$time</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[$replayContent]]></Content>
        </xml>
xml;
            echo $str;
            break;
        case "image"://图片消息
            break;
        case "event"://事件推送
            $event = $msg->Event;
            switch ($event){
                case "CLICK"://点击事件
                    $key = $msg->EventKey;
                    switch ($key){
                        case "qukuailiankecheng"://区块链课程
                            //回复文本消息
                            $str = <<<xml
        <xml>
            <ToUserName><![CDATA[$fromUserName]]></ToUserName>
            <FromUserName><![CDATA[$toUserName]]></FromUserName>
            <CreateTime>$time</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[国内首家区块链实战课程，带你基于python语言从0到1实战一个电子货币的实现，实现自己的比特币，感受去中心化的区块链核心理念，掌握业界最强区块链开源系统-龙链，应用到区块链的企业实战。快来了解！http://edu.51cto.com/px/train/232?wbbanner]]></Content>
        </xml>
xml;
                            file_put_contents("2.txt", $str);
                        echo $str;
                            break;
                        case "zhuanzaihezuo"://转载合作
                            //回复图片消息
                                $str = <<<xml
            <xml>
                <ToUserName><![CDATA[$fromUserName]]></ToUserName>
                <FromUserName><![CDATA[$toUserName]]></FromUserName>
                <CreateTime>$time</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                    <item>
                        <Title><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Title>
                        <Description><![CDATA[人民日报：中国不会任由美国乱舞大棒]]></Description>
                        <PicUrl><![CDATA[http://inews.gtimg.com/newsapp_ls/0/3202087085_150120/0]]></PicUrl>
                        <Url><![CDATA[https://news.qq.com/a/20180407/000499.htm]]></Url>
                    </item>
                </Articles>
            </xml>  
xml;
                            echo $str;
                            break;
                        case "jishuzhan"://技术栈
                            //回复图片消息
                                $str = <<<xml
            <xml>
                <ToUserName><![CDATA[$fromUserName]]></ToUserName>
                <FromUserName><![CDATA[$toUserName]]></FromUserName>
                <CreateTime>$time</CreateTime>
                <MsgType><![CDATA[image]]></MsgType>
                <Image><MediaId><![CDATA[BE5ztMJWFKcAkV_TWzIk5u7RkzC51rXB_0rIKKbxaaMsxvy_mjiaZf0d4xxbtC59]]></MediaId></Image>
            </xml>
xml;
                            echo $str;
                            break;
                    }
                    break;
                case "view"://网页事件
                    break;
                case "subscribe"://关注事件
                    $str = <<<xml
        <xml>
            <ToUserName><![CDATA[$fromUserName]]></ToUserName>
            <FromUserName><![CDATA[$toUserName]]></FromUserName>
            <CreateTime>$time</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[当前关注人数:$count]]></Content>
        </xml>
xml;
                    echo $str;
                    break;
                case "unsubscribe"://取消关注事件
                    break;
            }
            break;  
                    
    }
}




?>