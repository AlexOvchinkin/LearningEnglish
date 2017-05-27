<?php
$page = PAGE_AUTHORISATION;
include_once ROOT . '/views/Header.php';

include_once ROOT . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(ROOT . '/templates');
$twig = new Twig_Environment($loader, array());

$function = new Twig_Function('time', function () {
    return time();
});

$twig->addFunction($function);

echo $twig->render('Authorisation.tmpl', array(
    "csrfToken" => CSRF::getCSRFToken()
));

include_once ROOT . '/views/Footer.php';


