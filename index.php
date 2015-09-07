<?php
ini_set('display_errors', TRUE);
ini_set('error_reporting', -1);

echo "Starting..." . nl2br(PHP_EOL);
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function() use ($app) {
    return "This is main page!";
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

$app->run();
