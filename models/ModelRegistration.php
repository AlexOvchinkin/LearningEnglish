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

        // создадим нового юзера и получим его ID
        $userId = DB::addNewUser($userData['name'], $userData['email'], $password);

        // если юзер создан (ID отличен от 0)
        if ($userId) {
            // генерируем новый токен
            $userToken = (isset($_POST['remember'])) ? Validation::getNewUserToken() : '';

            // записываем его в ИБ
            if (DB::updateUserToken($userId, $userToken)) {

                // ... и в куки и сессию
                Validation::updateUserToken($userToken,
                    (isset($_POST['remember'])) ? LIVING_TIME_USER_TOKEN : 0);

                return true;
            }

        }

        // что то пошло не так
        return false;
    }
}