<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); ini_set('display_errors','On');
require __DIR__ . "/../vendor/autoload.php";

$app = new \Slim\Slim(['debug'=>true]);
$app->view->setTemplatesDirectory(__DIR__ . "/views");

$Data = new Testblog\Libs\Qdata\Qdata("localhost", "root", "111222", "testblog");
// echo "<pre>"; var_dump($Data); echo "<pre>";

// Just render template
$app->get('/(:layout)(/)', function ($layout="feed") use ($app) {
    in_array($layout, ["feed", "add"])
        ? $app->render($layout . ".php")
        : $app->notFound()
    ;
});

$app->run();
