<?php

class Safety {

    public static function renewToken() {
        if (!isset($_SESSION['CSRF-Token'])) {
            $token = time();
            $_SESSION['CSRF-Token'] = $token;
            setcookie('CSRF-Token', $token);
        }
    }

    public static function checkToken($token) {
        if (isset($_SESSION['CSRF-Token']) && $_SESSION['CSRF-Token'] == $token) {
            return true;
        }

        return false;
    }
}

