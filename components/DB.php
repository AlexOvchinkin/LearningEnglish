<?php

include_once(ROOT . '/components/config.php');

class DB {

    public static function getConnection() {

        $dsn = "mysql:dbname=" . DB_NAME . ";host=" . HOST;

        try {
            $connection = new PDO($dsn, USER, PASSWORD);
        } catch (PDOException $e) {
            $connection = null;
        }

        return $connection;
    }

    public static function getAllWords($user_id) {
        if (!empty($user_id)) {
            $connection = DB::getConnection();

            if (isset($connection)) {
                $sql = "SELECT 
                          user_vocabulary.word_id,
                          vocabulary.en_word,
                          vocabulary.ru_word
                        FROM
                          quick_english.user_vocabulary as user_vocabulary,
                          quick_english.vocabulary as vocabulary
                        WHERE
                          vocabulary.id = user_vocabulary.word_id 
                            and user_vocabulary.user_id = :id";

                $stm = $connection->prepare($sql);
                $stm->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stm->execute();

                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return null;
    }

    public static function getWordsArray($user_id, $numWords) {
        if (!empty($user_id)) {
            $connection = DB::getConnection();

            if (isset($connection)) {
                $sql = "SELECT 
                          user_vocabulary.word_id AS id,
                          vocabulary.en_word,
                          vocabulary.ru_word,
                          user_vocabulary.success_date,
                          user_vocabulary.success_percent
                        FROM
                            quick_english.user_vocabulary AS user_vocabulary
                                LEFT JOIN
                            quick_english.vocabulary AS vocabulary ON (user_vocabulary.word_id = vocabulary.id)
                        WHERE
                            CAST((UNIX_TIMESTAMP(CURRENT_DATE()) - UNIX_TIMESTAMP(user_vocabulary.success_date)) / 3600 / 24
                                  AS SIGNED) > :DIFF_SUCCESS_DATE
                                OR success_percent < 100
                        LIMIT :LIMIT";


                $stm = $connection->prepare($sql);

                $diff = DIFF_SUCCESS_DATE;
                $stm->bindParam(':DIFF_SUCCESS_DATE', $diff, PDO::PARAM_INT);
                $stm->bindParam(':LIMIT', $numWords, PDO::PARAM_INT);

                $stm->execute();

                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return null;
    }
}



