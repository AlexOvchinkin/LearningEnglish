<?php

class Safety {

    public static function renewToken() {
        if (!isset($_SESSION['CSRF-Token'])) {
            $token = time();
            $_SESSION['CSRF-Token'] = $token;
            setcookie('CSRF-Token', $token);
        }
    }

    public static function checkToken() {
        if (isset($_SESSION['CSRF-Token']) && isset($_COOKIE['CSRF-Token'])) {
            if ($_SESSION['CSRF-Token'] == $_COOKIE['CSRF-Token']) {
                return true;
            }
        }

        return false;
    }
}

