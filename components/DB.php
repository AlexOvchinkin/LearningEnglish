<?php

include_once(ROOT . '/components/config.php');

class DB {

    public static function getConnection() {

        $dsn = "mysql:dbname=" . DB_NAME . ";host=" . HOST;

        try {
            $connection = new PDO($dsn, USER, PASSWORD);

            // установим атрибуты - уберем эмуляцию prepare
            // пусть работает по настоящему
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            $connection = null;
        }

        return $connection;
    }

    # function getAllWords
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

    # function getWordsArray
    public static function getWordsArray($user_id, $dateDiff, $limit) {
        if (!empty($user_id)) {
            $connection = DB::getConnection();

            if (isset($connection)) {
                $sql = "SELECT 
                          user_vocabulary.word_id AS id,
                          vocabulary.en_word,
                          vocabulary.ru_word,
                          vocabulary.check_words,
                          user_vocabulary.success_date,
                          user_vocabulary.success_percent
                        FROM
                            quick_english.user_vocabulary AS user_vocabulary
                                LEFT JOIN
                            quick_english.vocabulary AS vocabulary ON (user_vocabulary.word_id = vocabulary.id)
                        WHERE
                            user_vocabulary.user_id = :user_id
                            AND 
                            (CAST((UNIX_TIMESTAMP(CURRENT_DATE()) - UNIX_TIMESTAMP(user_vocabulary.success_date)) 
                            / 3600 / 24 AS SIGNED) > :DIFF_SUCCESS_DATE
                            OR success_percent < 100)
                        LIMIT :LIMIT";

                $stm = $connection->prepare($sql);

                $stm->bindParam(':DIFF_SUCCESS_DATE', $dateDiff, PDO::PARAM_INT);
                $stm->bindParam(':LIMIT', $limit, PDO::PARAM_INT);
                $stm->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                $stm->execute();

                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return null;
    }

    # function getWordsCount
    public static function getWordsCount($user_id, $dateDiff) {
        if (!empty($user_id)) {
            $connection = DB::getConnection();

            if (isset($connection)) {
                $sql = "SELECT 
                          COUNT(user_vocabulary.word_id) as id
                        FROM
                            quick_english.user_vocabulary AS user_vocabulary
                        WHERE
                            user_vocabulary.user_id = :user_id
                            AND 
                            (CAST((UNIX_TIMESTAMP(CURRENT_DATE()) - UNIX_TIMESTAMP(user_vocabulary.success_date)) 
                            / 3600 / 24 AS SIGNED) > :DIFF_SUCCESS_DATE
                            OR success_percent < 100)";

                $stm = $connection->prepare($sql);

                $stm->bindParam(':DIFF_SUCCESS_DATE', $dateDiff, PDO::PARAM_INT);
                $stm->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                $stm->execute();

                if ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                    return $row['id'];
                }

                return 0;
            }
        }

        return 0;
    }

    # function getUserByEmail
    public static function getUserByEmail($email) {

        if (!empty($email)) {
            $connection = DB::getConnection();

            if (isset($connection)) {
                $sql = "SELECT 
                          id
                        FROM
                          quick_english.user
                        WHERE
                            email = :email";

                $stm = $connection->prepare($sql);
                $stm->bindParam(':email', $email, PDO::PARAM_STR);
                $stm->execute();

                if ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                    return $row['id'];
                }

                return 0;
            }
        }

        return 0;
    }

    # function addNewUser
    public static function addNewUser($name, $email, $password) {

        $connection = DB::getConnection();

        if (isset($connection)) {

            try {
                $sql = "insert into
                          quick_english.user (user_name, password, email)
                        values 
                          (:userName, :password, :email)";

                $stm = $connection->prepare($sql);

                $stm->bindParam(':userName', $name);
                $stm->bindParam(':password', $password);
                $stm->bindParam(':email', $email);

                // добавим запись в БД
                if ($stm->execute()) {
                    return true;
                }

                return false;

            } catch (PDOException $e) {
                return false;
            }
        }
    }
}



