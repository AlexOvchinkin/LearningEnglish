<?php

class Api {

    public function onAnswer() {
        try {
            $headers = getallheaders();

            if (isset($headers['Validation-Token'])) {
                if (Validation::checkCSRFToken($headers['Validation-Token'])) {
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

