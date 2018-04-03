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

$app->handle();