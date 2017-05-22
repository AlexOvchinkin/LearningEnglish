<?php

define('ROOT', dirname(__FILE__));
define('SERVER_ROOT', 'http://localhost/');

define('NUM_WORDS_PER_STEP', 5);
define('DIFF_SUCCESS_DATE', 7);

define('MODE_TRAINING', 1);
define('MODE_NO_WORDS', 2);
define('MODE_END_TRAINING', 3);

define('WRONG_ANSWER', 0);
define('RIGHT_ANSWER', 1);

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

Validation::generateNewSecretPhrase();

$router = new Router();
$router->run();
