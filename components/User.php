<?php

class User {

    # function generateUserToken
    public static function generateUserToken() {
        $randomString = CSRF::generateRandomString();
        return password_hash($randomString, PASSWORD_DEFAULT);
    }

    # function updateSessionToken
    public static function updateSessionToken($token) {
        $_SESSION['user-token'] = $token;
    }

    # function updateCookieToken
    public static function updateCookieToken($token, $time) {
        setcookie('user-token', $token, $time);
    }

    # function updateDatabaseToken
    public static function updateDatabaseToken($userId, $token) {

        try {

            $connection = DB::getConnection();

            if (isset($connection)) {

                $sql = "UPDATE
                            quick_english.user
                        SET token = :token
                        WHERE id = :id";

                $stm = $connection->prepare($sql);
                $stm->bindParam(':id', $userId);
                $stm->bindParam(':token', $token);

                if ($stm->execute()) {
                    return true;
                }
            }

        } catch (PDOException $e) {
            return false;
        }

        return false;
    }

    # function updateDatabaseToken
    public static function updateRemember($userId, $remember) {

        try {

            $connection = DB::getConnection();

            if (isset($connection)) {

                $sql = "UPDATE
                            quick_english.user
                        SET remember = :remember
                        WHERE id = :id";

                $stm = $connection->prepare($sql);
                $stm->bindParam(':id', $userId);
                $stm->bindParam(':remember', intval($remember));

                $stm->execute();
            }

        } catch (PDOException $e) {

        }
    }

    # function checkSessionUserToken
    public static function checkSessionUserToken($token) {

        if (isset($_SESSION['user-token']) && $_SESSION['user-token'] == $token) {
            return true;
        }

        return false;
    }

    # function checkSessionUserID
    public static function checkSessionUserID($id) {

        if (isset($_SESSION['user-id']) && $_SESSION['user-id'] == $id) {
            return true;
        }

        return false;
    }

    # function checkPassword
    public static function checkPassword($password, $databaseHash) {
        return password_verify($password, $databaseHash);
    }

    # function updateAllUserTokens
    public static function updateAllUserTokens($userId, $token, $remember) {

        if (self::updateDatabaseToken($userId, $token)) {

            self::updateSessionToken($token);
            self::updateCookieToken($token, ($remember) ? time() + LIVING_TIME_USER_TOKEN : 0);

            return true;
        }

        return false;
    }

    # function isAuthorized
    public static function isAuthorized() {

        if (isset($_COOKIE['user-token']) && self::checkSessionUserToken($_COOKIE['user-token'])
            && isset($_COOKIE['user-id']) && self::checkSessionUserID($_COOKIE['user-id'])) {

            return true;
        }

        return false;
    }
}





















