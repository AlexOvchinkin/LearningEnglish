<?php

class ControllerExamination {

    public function actionShow() {
        $model = new ModelExamination(1);
        $words = $model->getWordsList();

       include_once ROOT.'/views/ViewExamination.php';
    }
}