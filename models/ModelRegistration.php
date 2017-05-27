<?php

class ModelRegistration {

    # function isUserExists
    static function isUserExists($email) {
        return DB::getUserByEmail($email) != 0;
    }

    # function createUser
    static function createNewUser($userData) {

        // хэшируем пароль
        $password = password_hash($userData['password'], PASSWORD_BCRYPT);

        // создадим нового юзера
        if (DB::addNewUser($userData['name'], $userData['email'], $password)) {
            return true;
        }

        // что то пошло не так
        return false;
    }
}