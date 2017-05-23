<?php

class ControllerRegistration {

    public function actionShow() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['submit']) && isset($_POST['csrf-token'])
                && Validation::checkCSRFToken($_POST['csrf-token'])) {

                if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {

                    Validation::cleanPOST($_POST, array('name', 'email', 'password'));

                    if (ModelRegistration::isUserExists($_POST['email'])) {

                        $_SESSION['error-msg'] = 'Такой пользователь уже существует!';

                    } elseif (!self::checkPassword($_POST['password'])
                        || !self::checkEmail($_POST['email'])
                        || !self::checkLogin($_POST['name'])
                    ) {

                        $_SESSION['error-msg'] = 'Неверно указаны данные!';

                    } else {

                        // создаем нового юзера
                        if (ModelRegistration::createNewUser($_POST)) {

                            // установим флаг успеха для вьюшки
                            $_SESSION['success'] = true;

                            // отправим пользователя на главную
                            header('Location: /');
                            exit();

                        } else {
                            $_SESSION['error-msg'] = 'Ошибка создания нового пользователя!';
                        }
                    }
                } else {
                    $_SESSION['error-msg'] = 'Неверно указаны данные!';
                }
            }
        }

        include_once ROOT . '/views/ViewRegistration.php';
    }

    # function checkEmail
    static function checkEmail($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 45) {
            return true;
        }

        return false;
    }

    # function checkPassword
    static function checkPassword($password) {
        return preg_match("/^[a-zA-Z0-9]+$/", $password) === 1;
    }

    # function checkLogin
    static function checkLogin($login) {
        return strlen($login) <= 20;
    }
}


