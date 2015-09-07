<?php
require __DIR__ . "/../vendor/autoload.php";

$app = new \Slim\Slim();
$app->view->setTemplatesDirectory(__DIR__ . "/views");

// Just render template
$app->get('/(:layout)(/)', function ($layout="feed") use ($app) {
    in_array($layout, ["feed", "add"])
        ? $app->render($layout . ".php")
        : $app->notFound()
    ;
});

$app->run();
