<?php

class CSRF {

    # function generateNewSecretPhrase
    public static function generateSessionSecretPhrase() {
        if (!isset($_SESSION['csrf_secret'])) {
            $secret = CSRF::generateRandomString();
            $_SESSION['csrf_secret'] = $secret;
        }
    }

    # function getSessionToken
    public static function getCSRFToken() {
        if (isset($_SESSION['csrf_secret'])) {
            return password_hash($_SESSION['csrf_secret'], PASSWORD_BCRYPT);
        }

        return null;
    }

    # function checkToken
    public static function checkCSRFToken($token) {
        if (isset($_SESSION['csrf_secret'])) {
            return password_verify($_SESSION['csrf_secret'], $token);
        }

        return false;
    }

    # function generateRandString
    public static function generateRandomString() {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $length = strlen($chars) - 1;

        while (strlen($code) < 6) {
            $code .= $chars[mt_rand(0, $length)];
        }

        return $code;
    }
}
























