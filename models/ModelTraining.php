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
        $arrayOfAlgorithmes = Algorithm::getAlgorithmesArray();

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

    # function getWordStatus
    public static function getWordStatus($userID, $wordID) {

        $connection = DB::getConnection();

        if (isset($connection)) {

            $sql = "SELECT 
                        success_date, 
                        success_percent
                    FROM
                        quick_english.user_vocabulary
                    WHERE
                        word_id = :wordID AND user_id = :userID";

            $stm = $connection->prepare($sql);

            $stm->bindParam(':wordID', $wordID, PDO::PARAM_STR);
            $stm->bindParam(':userID', $userID, PDO::PARAM_INT);

            $stm->execute();

            if ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                return $row;
            }

            return array();
        }
    }

    # function getWordStatus
    public static function setWordStatus($userID, $wordID, $status) {

        $today = date('Y-m-d');
        $wordData = self::getWordStatus($userID, $wordID);

        if (count($wordData) > 0
            && ($wordData['success_date'] != $today || $status == WRONG_ANSWER)) {

            $connection = DB::getConnection();

            if (isset($connection)) {

                $sql = "insert into 
                          quick_english.user_vocabulary (user_id, word_id, success_date, success_percent)
                        values (:user_id, :word_id, :success_date, :success_percent) 
                        on duplicate key update 
                          success_date = values(success_date), 
                          success_percent = values(success_percent)";



                $stm = $connection->prepare($sql);

                $stm->bindParam(':word_id', $wordID, PDO::PARAM_STR);
                $stm->bindParam(':user_id', $userID, PDO::PARAM_INT);

                $successPercent = $wordData['success_percent'];

                // в случае правильного ответа увеличим степень выученности слова
                if ($status == RIGHT_ANSWER) {
                    $successPercent += 10;
                    $successPercent = ($successPercent > 100) ? 100 : $successPercent;
                } else {
                    // ... неправильного - уменьшим
                    $successPercent -= 10;
                    $successPercent = ($successPercent < 0) ? 0 : $successPercent;
                }

                // дата всегда текущая
                $stm->bindParam(':success_date', $today, PDO::PARAM_STR);
                $stm->bindParam(':success_percent', $successPercent, PDO::PARAM_INT);

                $stm->execute();
            }
        }
    }

}




















