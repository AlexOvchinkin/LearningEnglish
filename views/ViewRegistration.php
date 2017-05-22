<?php
$registrationPage = true;
include_once ROOT . '/views/Header.php';

include_once ROOT . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(ROOT . '/templates');
$twig = new Twig_Environment($loader, array());

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
    "csrfToken" => Validation::getCSRFToken(),
    "errorMsg" => $errorMsg,
    "success" => $success
));

if ($success) {
    header("refresh: 2; url=/");
    exit();
}




