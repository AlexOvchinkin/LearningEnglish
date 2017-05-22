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
                        || !self::checkEmail($_POST['email'])) {

                        $_SESSION['error-msg'] = 'Неверно указаны данные!';

                    } else {

                        ModelRegistration::createUser(array(
                            'name' => $_POST['name'],
                            'email' => $_POST['email'],
                            'password' => $_POST['password']
                        ));

                        $_SESSION['success'] = true;
                    }

                } else {
                    $_SESSION['error-msg'] = 'Неверно указаны данные!';
                }

                unset($_POST['submit']);
                header('Location: /registration');
                exit();
            }
        } else {
            include_once ROOT . '/views/ViewRegistration.php';
        }
    }

    # function checkEmail
    static function checkEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    # function checkPassword
    static function checkPassword($password) {
        return preg_match("/^[a-zA-Z0-9]+$/", $password) === 1;
    }
}


