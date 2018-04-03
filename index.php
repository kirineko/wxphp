<?php
/**
 * Copyright by DreamCreate.
 * project: wxphp
 * file: index.php
 * author: kirineko
 * time: 2018/04/04, 01:38:23
 */

use Phalcon\Mvc\Micro;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Receive\{ Msg, TextMsg,  ImageMsg, Parse};
use Reply\TextMsg as ReplyMsg;

$logger = new FileAdapter('./logs/test.log');

$app = new Micro();

$app->get(
    "/wx",
    function() use ($app, $logger) {
        try {
            $request = $app->request;
            $signature = $request->getQuery('signature');
            $timestamp = $request->getQuery('timestamp');
            $nonce = $request->getQuery('nonce');
            $echostr = $request->getQuery('echostr');
            $token = 'hello2016';

            $list = [$token, $timestamp, $nonce];
            sort($list);
            $str_list = '';
            foreach($list as $item) {
                $str_list .= $item;
            }
            $hashcode = sha1($str_list);
            $logger->info("handle/GET func: hashcode, signature: " . $hashcode . " " . $signature);
            if ($hashcode == $signature) {
                $app->response->setContent($echostr);
                $app->response->send();
            } else {
                $app->response->setContent('');
                $app->response->send();
            }
        } catch (Exception $e) {
            $app->response->setContent($e);
            $app->response->send();
        }
    }
);

$app->post(
    "/wx",
    function() use ($app, $logger) {
        try {
            $xml_data = file_get_contents("php://input");
            $logger->info(print_r($xml_data,true));
            $recMsg = Receive\Parse::parse_xml($xml_data);
            if ($recMsg instanceof Receive\TextMsg) {
                $toUser = $recMsg->FromUserName;
                $fromUser = $recMsg->ToUserName;
                $content = $recMsg->Content;
                $replyMsg = new ReplyMsg($toUser, $fromUser, $content);
                $res = $replyMsg->send();
                $logger->info("The result:\n" . $res . "\n");
                $app->response->setContent($res);
                $app->response->send();
            } else {
                $app->response->setContent('success');
                $app->response->send();
            }
        } catch (Exception $e) {
            $app->response->setContent($e);
            $app->response->send();
        }
    }
);

$app->handle();