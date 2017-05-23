<?php

class Api {

    public function onAnswer() {
        try {
            $headers = getallheaders();

            if (isset($headers['CSRF-Token'])) {
                if (Validation::checkCSRFToken($headers['CSRF-Token'])) {
                    if (isset($_POST['ANSWER'])) {
                        if (ControllerTraining::modifyWordsArray($_POST['ANSWER'])) {
                            echo '/training';
                            exit();
                        }
                    }
                }
            }

            echo '/404';

        } catch (Exception $e) {
            echo '/404';
        }
    }
}

