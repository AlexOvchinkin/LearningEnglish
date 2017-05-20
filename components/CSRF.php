<?php

class CSRF {

    # function generateNewSecretPhrase
    public static function generateNewSecretPhrase() {
        if (!isset($_SESSION['csrf_secret'])) {
            $secret = CSRF::generateRandString();
            $_SESSION['csrf_secret'] = $secret;
        }
    }

    # function getSessionToken
    public static function getSessionToken() {
        if (isset($_SESSION['csrf_secret'])) {
            return password_hash($_SESSION['csrf_secret'], PASSWORD_DEFAULT);
        }

        return null;
    }

    # function checkToken
    public static function checkToken($token) {
        if (isset($_SESSION['csrf_secret'])) {
            return password_verify($_SESSION['csrf_secret'], $token);
        }

        return false;
    }

    # function generateRandString
    public static function generateRandString() {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $length = strlen($chars) - 1;

        while (strlen($code) < 6) {
            $code .= $chars[mt_rand(0, $length)];
        }

        return $code;
    }
}

