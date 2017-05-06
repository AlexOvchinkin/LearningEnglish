<?php

class ControllerVocabulary {

    public function actionShow() {
        $model = new ModelVocabulary(1);
        $words = $model->getWordsList();

       include_once ROOT . '/views/ViewVocabulary.php';
    }
}