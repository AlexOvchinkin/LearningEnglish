<?php

class ControllerRegistration {

    public function actionShow() {
        include_once ROOT.'/views/ViewRegistration.php';
    }

    public function register() {
        if (isset($_POST['submit']) && isset($_POST['csrf-token'])
        && CSRF::checkToken($_POST['csrf-token'])) {

            echo "OK";
        } else {
            echo 'WRONG';
        }
    }

}

