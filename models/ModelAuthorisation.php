<?php

class ModelAuthorisation {

    # function getUserDataByID
    public static function getUserDataByID($userID) {

        $connection = DB::getConnection();

        if (isset($connection)) {

            $sql = "SELECT 
                        user_name,
                        token,
                        remember          
                    FROM
                        quick_english.user
                    WHERE id = :id";

            $stm = $connection->prepare($sql);
            $stm->bindParam(":id", $userID, PDO::PARAM_INT);

            if ($stm->execute()) {
                if ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                    return $row;
                }
            }

            return array();
        }
    }

    # function getUserDataByID
    public static function getUserDataByEmail($email) {

        $connection = DB::getConnection();

        if (isset($connection)) {

            $sql = "SELECT 
                        user_name,
                        id,
                        password                       
                    FROM
                        quick_english.user
                    WHERE email = :email";

            $stm = $connection->prepare($sql);
            $stm->bindParam(":email", $email, PDO::PARAM_STR);

            if ($stm->execute()) {
                if ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                    return $row;
                }
            }

            return array();
        }
    }
}

