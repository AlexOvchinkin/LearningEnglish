<?php

class ControllerOther extends Controller {

    public function actionShow($param = null) {

        $header = '404';
        $text = 'Такая страница не найдена!';

        include_once ROOT . '/views/OtherPageView.php';
    }
}

