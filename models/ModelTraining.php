<?php

class ModelTraining {

    private $user_id;

    # constructor
    public function __construct($user_id) {
        $this->user_id = $user_id;
    }

    # function cmp
    public function cmp($a, $b) {
        return $a['sortKey'] >= $b['sortKey'] ? 1 : 0;
    }

    # function getWordsArray
    public function getWordsArray($numWords) {
        $wordsArray = DB::getWordsArray($this->user_id, DIFF_SUCCESS_DATE, $numWords);

        if (count($wordsArray) == 0) {
            return null;
        }

        $checkArray = array();
        $arrayOfAlgorithmes = include_once ROOT . '/Algorithmes.php';

        if (isset($wordsArray)) {
            foreach ($wordsArray as $value) {
                foreach ($arrayOfAlgorithmes as $key => $template) {
                    $newElement = $value;
                    $newElement['template'] = $template;
                    $newElement['sortKey'] = $key;
                    $checkArray[] = $newElement;
                }
            }
        }

        usort($checkArray, array($this, "cmp"));
        return $checkArray;
    }

    # function getCountRemainedWords
    public function getCountRemainedWords() {
        return DB::getWordsCount($this->user_id, DIFF_SUCCESS_DATE);
    }

}

