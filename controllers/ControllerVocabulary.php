<?php

class ControllerVocabulary {

    private $model;

    public function __construct() {
        $this->model = new ModelVocabulary(1);
    }

    public function actionShow() {
        $words = $this->model->getWordsList();
        include_once ROOT . '/views/ViewVocabulary.php';
    }
}