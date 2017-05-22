<?php

class ModelRegistration {

    static function isUserExists($email) {
        return DB::getUserByEmail($email) != 0;
    }

    static function createUser($userData) {

    }
}