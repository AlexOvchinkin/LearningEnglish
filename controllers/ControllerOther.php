<?php

class ControllerOther {

    public function actionShow($num) {

        $header = '404';
        $text = 'Такая страница не найдена!';

        include_once ROOT . '/views/OtherPageView.php';
    }
}

