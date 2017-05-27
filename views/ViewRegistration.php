<?php
$page = PAGE_REGISTRATION;
include_once ROOT . '/views/Header.php';

include_once ROOT . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(ROOT . '/templates');
$twig = new Twig_Environment($loader, array());

$function = new Twig_Function('time', function () {
    return time();
});

$twig->addFunction($function);

$errorMsg = '';
$success = false;

if (isset($_SESSION['error-msg'])) {
    $errorMsg = $_SESSION['error-msg'];
    unset($_SESSION['error-msg']);
}

if (isset($_SESSION['success'])) {
    $success = true;
    unset($_SESSION['success']);
}

echo $twig->render('Registration.tmpl', array(
    "csrfToken" => CSRF::getCSRFToken(),
    "name" => (isset($_POST['name'])) ? $_POST['name'] : '',
    "email" => (isset($_POST['email'])) ? $_POST['email'] : '',
    "errorMsg" => $errorMsg,
    "success" => $success
));

include_once ROOT . '/views/Footer.php';




