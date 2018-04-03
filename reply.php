<?php
/**
 * Copyright by DreamCreate.
 * project: wxphp
 * file: reply.php
 * author: kirineko
 * time: 2018/04/04, 03:21:36
 */

namespace Reply;

class Msg
{
    public function __construct()
    {
    }

    public function send()
    {
        return "success";
    }
}

class TextMsg extends Msg
{
    public $__dict = [];
    public function __construct($toUserName, $fromUserName, $content)
    {
        $this->__dict['ToUserName'] = $toUserName;
        $this->__dict['FromUserName'] = $fromUserName;
        $this->__dict['Content'] = $content;
        $this->__dict['CreateTime'] = time();
    }

    public function send()
    {
        $res = <<< EOF
        <xml>
        <ToUserName><![CDATA[$this->__dict['ToUserName']]]></ToUserName>
        <FromUserName><![CDATA[$this->__dict['FromUserName']]]></FromUserName>
        <CreateTime>$this->__dict['CreateTime']</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[$this->__dict['Content']]]></Content>
        </xml>
EOF;
        return $res;
    }
}

class ImageMsg extends Msg
{
    public $__dict = [];
    public function __construct($toUserName, $fromUserName, $mediaId)
    {
        $this->__dict['ToUserName'] = $toUserName;
        $this->__dict['FromUserName'] = $fromUserName;
        $this->__dict['MediaId'] = $mediaId;
        $this->__dict['CreateTime'] = time();
    }

    public function send()
    {
        $res = <<< EOF
        <xml>
        <ToUserName><![CDATA[$this->__dict['ToUserName']]]></ToUserName>
        <FromUserName><![CDATA[$this->__dict['FromUserName']]]></FromUserName>
        <CreateTime>$this->__dict['CreateTime']</CreateTime>
        <MsgType><![CDATA[image]]></MsgType>
        <Image>
        <MediaId><![CDATA[$this->__dict['MediaId']]]></MediaId>
        </Image>
        </xml>
EOF;
        return $res;
    }
}