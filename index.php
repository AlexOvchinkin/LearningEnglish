<?php

define('ROOT', dirname(__FILE__));

session_start();

spl_autoload_register(function ($className) {

    $folders = array(
        '/',
        '/controllers/'
    );

    foreach ($folders as $folder) {
        if (file_exists(ROOT . $folder . $className . '.php')) {
            include_once ROOT . $folder . $className . '.php';
            break;
        }
    }
});

$router = new Router();
$router->run();
