<?php

class Validation {

    # function generateNewSecretPhrase
    public static function generateNewSecretPhrase() {
        if (!isset($_SESSION['csrf_secret'])) {
            $secret = Validation::generateRandString();
            $_SESSION['csrf_secret'] = $secret;
        }
    }

    # function getSessionToken
    public static function getCSRFToken() {
        if (isset($_SESSION['csrf_secret'])) {
            return password_hash($_SESSION['csrf_secret'], PASSWORD_DEFAULT);
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
    public static function generateRandString() {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $length = strlen($chars) - 1;

        while (strlen($code) < 6) {
            $code .= $chars[mt_rand(0, $length)];
        }

        return $code;
    }

    # function cleanString
    public static function cleanString($string) {
        $newString = trim($string);
        $newString = stripcslashes($newString);
        $newString = strip_tags($newString);
        $newString = htmlspecialchars($newString);

        return $newString;
    }

    # function cleanPOST
    public static function cleanPOST(&$post, $elements) {
        foreach ($elements as $key) {
            if (isset($post[$key])) {
                $post[$key] = self::cleanString($post[$key]);
            }
        }
    }
}
























