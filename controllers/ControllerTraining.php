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
        $wordsArray = $this->model->getWordsArray($numWords);

        if (is_null($wordsArray)) {
            return false;
        }

        $_SESSION['words_array'] = $wordsArray;

        if ($this->isWordArrayExist()) {
            return true;
        }

        return false;
    }

    # function modifyWordsArray
    public static function modifyWordsArray($status) {
        if ($status == RIGHT_ANSWER) {
            if (isset($_SESSION['words_array'])) {
                array_shift($_SESSION['words_array']);
            }

            return true;
        } elseif ($status == WRONG_ANSWER) {
            if (isset($_SESSION['words_array'])) {
                $currentElement = array_shift($_SESSION['words_array']);
                array_push($_SESSION['words_array'], $currentElement);
            }

            return true;
        } else {
            return false;
        }
    }

    # function actionShow
    public function actionShow() {
        if (isset($_SERVER['HTTP_REFERER']) && preg_match("~^" . SERVER_ROOT . "~", $_SERVER['HTTP_REFERER']) === 1) {
            if ($this->isWordArrayExist()) {
                $wordsArray = $_SESSION['words_array'];

                if (count($wordsArray) == 0) {
                    $remainedWords = $this->model->getCountRemainedWords();

                    if ($remainedWords == 0) {
                        $mode = MODE_NO_WORDS;
                    } else {
                        $mode = MODE_END_TRAINING;
                    }

                    unset($_SESSION['words_array']);

                } else {
                    $mode = MODE_TRAINING;
                    $trainingData = $wordsArray[0];
                }
            } else {
                if ($this->createWordsArray(NUM_WORDS_PER_STEP)) {
                    header("Location: /training");
                    exit();
                } else {
                    $mode = MODE_NO_WORDS;
                }
            }

            include_once ROOT . '/views/TrainingView.php';

        } else {
            header("Location: /");
            exit();
        }

    }
}


























