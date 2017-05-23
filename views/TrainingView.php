<?php
$trainingPage = true;

include_once ROOT . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(ROOT . '/templates');
$twig = new Twig_Environment($loader, array());

$function = new Twig_Function('time', function () {
    return time();
});

$twig->addFunction($function);

include_once ROOT . '/views/Header.php';

if ($mode == MODE_END_TRAINING) {

    echo $twig->render('EndTraining.tmpl', array(
        "remainedWords" => $remainedWords
    ));

} elseif ($mode == MODE_TRAINING) {

    if (isset($trainingData)) {
        $className = $trainingData['template'];
        $classObject = new $className($trainingData);

        echo $twig->render($classObject->getTemplate(), $classObject->getParams());
    }
}

include_once ROOT . '/views/Footer.php';

