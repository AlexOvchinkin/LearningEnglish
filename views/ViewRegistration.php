<?php
$registrationPage = true;
include_once ROOT . '/views/Header.php';

include_once ROOT . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(ROOT . '/templates');
$twig = new Twig_Environment($loader, array());

echo $twig->render('Registration.tmpl', array(
    "csrfToken" => CSRF::getSessionToken()
));



