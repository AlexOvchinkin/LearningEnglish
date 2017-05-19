<?php

class ControllerVocabulary extends Controller {

    private $model;

    public function __construct() {
        $this->model = new ModelVocabulary(1);
    }

    public function actionShow() {
        if (isset($_SESSION['words_array'])) {
            unset($_SESSION['words_array']);
        }

        $words = $this->model->getWordsList();
        include_once ROOT . '/views/ViewVocabulary.php';
    }
}