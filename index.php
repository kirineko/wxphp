<?php
/**
 * Copyright by DreamCreate.
 * project: wxphp
 * file: index.php
 * author: kirineko
 * time: 2018/04/04, 01:38:23
 */

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    "/wx",
    function() use ($app) {
        $app->response->setContentType("text/plain");
        $app->response->sendHeaders();
        $app->response->setContent("hello world!");
        $app->response->send();
    }
);

$app->handle();