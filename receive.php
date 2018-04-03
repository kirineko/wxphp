<?php
/**
 * Copyright by DreamCreate.
 * project: wxphp
 * file: receive.php
 * author: kirineko
 * time: 2018/04/04, 03:21:21
 */

namespace Receive;

class Parse
{
    public static function parse_xml($xml_data) {
        $xml = simplexml_load_string($xml_data);
        $data = json_decode(json_encode($xml),TRUE);
        $msg_type = $data['MsgType'];
        if ($msg_type == 'text') {
            return new TextMsg($data);
        } else {
            return new ImageMsg($data);
        }
    }
}

class Msg
{
    public $ToUserName;
    public $FromUserName;
    public $CreateTime;
    public $MsgType;
    public $MsgId;
    public function __construct($data)
    {
        $this->CreateTime = $data['ToUserName'];
        $this->FromUserName = $data['FromUserName'];
        $this->ToUserName = $data['ToUserName'];
        $this->MsgId = $data['MsgId'];
        $this->MsgType = $data['MsgType'];
    }
}

class TextMsg extends Msg
{
    public $Content;
    public function __construct($data)
    {
        parent::__construct($data);
        $this->Content = $data['Content'];
    }
}

class ImageMsg extends Msg
{
    public $PicUrl;
    public $MediaId;
    public function __construct($data)
    {
        parent::__construct($data);
        $this->PicUrl = $data['PicUrl'];
        $this->MediaId = $data['MediaId'];
    }
}