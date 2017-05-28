<?php

define('ROOT', dirname(__FILE__));
define('SERVER_ROOT', 'http://localhost/');

define('NUM_WORDS_PER_STEP', 5);
define('DIFF_SUCCESS_DATE', 7);
define('PERCENT_GROW', 20);

define('MODE_TRAINING', 1);
define('MODE_NO_WORDS', 2);
define('MODE_END_TRAINING', 3);

define('WRONG_ANSWER', 0);
define('RIGHT_ANSWER', 1);

define('LIVING_TIME_USER_TOKEN', 60*60*24*30);

define('PAGE_MAIN', 1);
define('PAGE_VOCABULARY', 2);
define('PAGE_TRAINING', 3);
define('PAGE_OTHER', 4);
define('PAGE_REGISTRATION', 5);
define('PAGE_AUTHORISATION', 6);

session_start();

spl_autoload_register(function ($className) {

    $folders = array(
        '/',
        '/components/',
        '/components/AlgorithmesClasses/',
        '/controllers/',
        '/models/'
    );

    foreach ($folders as $folder) {
        if (file_exists(ROOT . $folder . $className . '.php')) {
            include_once ROOT . $folder . $className . '.php';
            break;
        }
    }
});

CSRF::generateSessionSecretPhrase();

$router = new Router();
$router->run();
