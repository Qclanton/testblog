<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); ini_set('display_errors','On');
require __DIR__ . "/../vendor/autoload.php";

$app = new \Slim\Slim(['debug'=>true]);
$app->view->setTemplatesDirectory(__DIR__ . "/views");

// Just render template
$app->get('/(:layout)(/)', function ($layout="feed") use ($app) {
    if ($layout === "test") {
        $Database = new Testblog\Libs\Qdata\Mysql("localhost", "root", "111222", "testblog");
        // echo "<pre>"; var_dump($Database); echo "<pre>";
        
        
        $Database
            ->transactionStart()
                ->execute("UPDATE `posts` SET `text`=? WHERE `id`=?", ["YYYYYYYYYYYYY", 1])
                ->execute("UPDATE `posts` SET `text`=? WHERE `id`=?", ["XXXXXXXXXX", 2])
                ->execute("INSERT INTO `posts` (`title`, `text`) VALUES (?, ?)", ["test", "test"])
            ->transactionEnd()
        ;
        
        // $Database->execute("INSERT INTO `posts`  VALUES ('1', 'test', 'test')");
        
        // $Database->execute("UPDATE `posts` SET `text`=? WHERE `id`=?", ["SSSSSSSSSSS", 1]);
        // $Database->execute("UPDATE `posts` SET `text`=? WHERE `id`=?", ["KKKKK", 1]);
        
        /*
        $posts = $Database->getRows("SELECT * FROM `posts` WHERE `id` IN (?,?)", [1,2]);
        echo "---POSTS---" . nl2br(PHP_EOL);
        foreach ($posts as $post) {            
            echo "<pre>"; var_dump($post); echo "<pre>";
        }
        */
        /*
        $Database
            ->transactionStart()
                ->execute()
        */
        
        /*
        $post = $Database->getValue("SELECT `title` FROM `posts` WHERE `id` = ?", [1]);
        echo "<pre>"; var_dump($post); echo "<pre>";
        */
        
        /*
        $posts = $Database->getRows("SELECT * FROM `posts` WHERE `id` IN (?,?)", [1,2]);
        echo "---POSTS---" . nl2br(PHP_EOL);
        foreach ($posts as $post) {            
            echo "<pre>"; var_dump($post); echo "<pre>";
        }
        */
    } else {
        in_array($layout, ["feed", "add"])
            ? $app->render($layout . ".php")
            : $app->notFound()
        ;
    }
});

$app->run();
