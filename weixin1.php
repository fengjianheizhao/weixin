<?php



header("Content-type: text/html; charset=utf-8");
$nonce = $_GET['nonce'];
$token = 'winxin';
$timestamp = $_GET['timestamp'];
if (isset($_GET['echostr'])) {
    if (bindServerCheck()) {
        echo $_GET['echostr'];
    }
    exit();
}
responseMsg();


//消息回复
function responseMsg() {
    //1.获取到微信推送过来post数据（xml格式）
    $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];

    //libxml_disable_entity_loader(true);
    //2.处理消息类型，并设置回复类型和内容
    $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
    //判断该数据包是否是订阅de事件推送
    if (strtolower($postObj->MsgType) == 'event') {
        //如果是关注 subscribe事件

        if (strtolower($postObj->Event) == 'subscribe') {
            $toUser = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $time = time();
            $msgType = 'text';
            $content = '欢迎关注我的微信公众号: 微信公众号。';




            //修改为
            if (is_utf8($content)) {
                $content = $content;
            } else {
                $content = iconv('gb2312', 'UTF-8//IGNORE', $content);
            }

            $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
            $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
            echo $info;
        }




    }



    if (strtolower($postObj->MsgType) == 'text') {
        //如果是关注 subscribe事件

        // if (strtolower($postObj->Event) == 'subscribe') {
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
        $msgType = 'text';
        $keyword = trim($postObj->Content);



        if ($keyword=='图片'){



            $arr = array(
                array(
                    'title'=>'微信公众号',
                    'description'=>"微信公众号的官方网站。",
                    'picUrl'=>'http://wwwmages/logo.jpg',
                    'url'=>'http://www.baidu.com',
                ),
            );
            $template = "<xml>  
                        <ToUserName><![CDATA[%s]]></ToUserName>  
                        <FromUserName><![CDATA[%s]]></FromUserName>  
                        <CreateTime>%s</CreateTime>  
                        <MsgType><![CDATA[%s]]></MsgType>  
                        <ArticleCount>".count($arr)."</ArticleCount>  
                        <Articles>";
            foreach($arr as $k=>$v){
                $template .="<item>  
                            <Title><![CDATA[".$v['title']."]]></Title>   
                            <Description><![CDATA[".$v['description']."]]></Description>  
                            <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>  
                            <Url><![CDATA[".$v['url']."]]></Url>  
                            </item>";
            }
            $template .="</Articles>  
                        </xml> ";
            echo sprintf($template, $toUser, $fromUser, time(), 'news');

        }




        if ($keyword=='多图片'){



            $arr = array();
            $arr[] = array("title"=>"司", "Description"=>"", "picUrl"=>"http://778.jpg", "url" =>"http://51822.html");
            $arr[] = array("title"=>"成", "Description"=>"", "picUrl"=>"http://833_28919.jpg", "url" =>"http://61929.html");
            $arr[] = array("title"=>"办", "Description"=>"", "picUrl"=>"http://8.jpg", "url" =>"http://161207.html");



            $template = "<xml>  
                        <ToUserName><![CDATA[%s]]></ToUserName>  
                        <FromUserName><![CDATA[%s]]></FromUserName>  
                        <CreateTime>%s</CreateTime>  
                        <MsgType><![CDATA[%s]]></MsgType>  
                        <ArticleCount>".count($arr)."</ArticleCount>  
                        <Articles>";
            foreach($arr as $k=>$v){
                $template .="<item>  
                            <Title><![CDATA[".$v['title']."]]></Title>   
                            <Description><![CDATA[".$v['description']."]]></Description>  
                            <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>  
                            <Url><![CDATA[".$v['url']."]]></Url>  
                            </item>";
            }
            $template .="</Articles>  
                        </xml> ";
            echo sprintf($template, $toUser, $fromUser, time(), 'news');

        }


        if ($keyword=='小苹果'){


            $tetle = '小苹果';
            $des = '这是一首非常好听的歌曲';
            $MusicUrl = 'http://g.mp3';


            $textTpl = "<xml>
				  <ToUserName>< ![CDATA[%s] ]></ToUserName>
				  <FromUserName>< ![CDATA[%s] ]></FromUserName>
				  <CreateTime>%s</CreateTime>
				  <MsgType>< ![CDATA[music] ]></MsgType>
				  <Music>
				  <Title>< ![CDATA[$tetle] ]></Title>
				  <Description>< ![CDATA[$des] ]></Description>
				  <MusicUrl>< ![CDATA[$MusicUrl] ]></MusicUrl>
				  <HQMusicUrl>< ![CDATA[$MusicUrl] ]></HQMusicUrl>
				  <ThumbMediaId>< ![CDATA[media_id] ]></ThumbMediaId>
				  </Music>
				  </xml>";
            $msgType = "music";

            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
            echo $resultStr;


            // $resultStr = sprintf($Musictpl, $fromUsername, $toUsername, $time, $title, $decription, $music_url, $music_url);
            // echo $resultStr;

        }







        $content = '你输入的信息是:['.$keyword.'] 当前时间是:'.date("Y-w-d h:i:sa");




        //修改为
        if (is_utf8($content)) {
            $content = $content;
        } else {
            $content = iconv('gb2312', 'UTF-8//IGNORE', $content);
        }

        $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
        $info = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
        echo $info;
        // }




    }








}


// 开发者模式绑定校验
function bindServerCheck($token) {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $tmpArr = array(
        $token,
        $timestamp,
        $nonce
    );
    sort($tmpArr);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);
    if ($tmpStr == $signature) {
        return true;
    } else {
        return false;
    }
}




function to_utf8($in)
{
    if (is_array($in)) {
        foreach ($in as $key => $value) {
            $out[to_utf8($key)] = to_utf8($value);
        }
    } elseif(is_string($in)) {
        if(mb_detect_encoding($in) != "UTF-8")
            return utf8_encode($in);
        else
            return $in;
    } else {
        return $in;
    }
    return $out;
}




function is_utf8($str)
{
    return preg_match('//u', $str);
}

function music($url,$tetle,$des) {
    $MusicUrl=$url;
    $tetle=$tetle;
    $des=$des;
    $textTpl = " <xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                             <Music>
                             <Title><![CDATA[$tetle]]></Title>
                             <Description><![CDATA[$des]]></Description>
                             <MusicUrl><![CDATA[$MusicUrl]]></MusicUrl>
                             <HQMusicUrl><![CDATA[$MusicUrl]]></HQMusicUrl>
                             </Music>
                             <FuncFlag>0</FuncFlag>
                             </xml>";
    $msgType = "music";

    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    echo $resultStr;
}
