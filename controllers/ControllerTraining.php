<?php

class ControllerTraining {

    private $model;

    public function __construct() {
        $this->model = new ModelTraining(1);
    }

    # function isWordArrayExist
    private function isWordArrayExist() {
        if (isset($_SESSION['words_array'])) {
            return true;
        }

        return false;
    }

    # function createWordsArray
    private function createWordsArray($numWords) {
        $_SESSION['words_array'] = $this->model->getWordsArray($numWords);

        if ($this->isWordArrayExist()) {
            return true;
        }

        return false;
    }

    private function getTrainingData($wordsArray) {
        $trainingData = array_shift($wordsArray);
        $_SESSION['words_array'] = $wordsArray;
        return $trainingData;
    }

    # function actionShow
    public function actionShow() {
        if (isset($_SERVER['HTTP_REFERER']) && preg_match("~^" . SERVER_ROOT . "~", $_SERVER['HTTP_REFERER']) === 1) {
            if ($this->isWordArrayExist()) {
                $wordsArray = $_SESSION['words_array'];

                if (count($wordsArray) == 0) {
                    $mode = MODE_END_TRAINING;
                    unset($_SESSION['words_array']);
                } else {
                    $mode = MODE_TRAINING;
                    $trainingData = $this->getTrainingData($wordsArray);
                }
            } else {
                if ($this->createWordsArray(NUM_WORDS_PER_STEP)) {
                    header("Location: /training");
                    exit();
                } else {
                    $mode = MODE_NO_WORDS;
                }
            }

            include_once ROOT . '/views/WordTrainingView.php';

        } else {
            header("Location: /");
            exit();
        }

    }
}


























