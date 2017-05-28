<?php

class ControllerAuthorisation extends Controller {

    private function validateForm() {

        // если нажата кнопка регистрации ...
        if (isset($_POST['submit-registration'])) {
            header('Location: /registration');
            exit();
        }

        // если нажата кнопка авторизации и валидирован csrf-токен
        if (isset($_POST['submit-authorisation'])
            && isset($_POST['csrf-token'])
            && CSRF::checkCSRFToken($_POST['csrf-token'])) {

            if (isset($_POST['email']) && isset($_POST['password'])) {

                $email = $_POST['email'];
                $password = $_POST['password'];

                // получим структуру данных юзера
                if (count($userData = ModelAuthorisation::getUserDataByEmail($email)) > 0) {

                    $dbHash = $userData['password'];
                    $remember = isset($_POST['remember']) ? true : false;
                    $userID = $userData['id'];
                    $userName = $userData['user_name'];

                    // если пароль верный
                    if (User::checkPassword($password, $dbHash)) {

                        // перегенерируем все токены
                        $token = User::generateUserToken();

                        if (User::updateAllUserTokens($userID, $token, $remember)) {

                            User::updateRemember($userID, $remember);

                            // запишем в куки id юзера
                            setcookie('user-id', $userID, ($remember) ? time() + LIVING_TIME_USER_TOKEN : 0);

                            // запишем в сессию имя пользователя
                            $_SESSION['user-name'] = $userName;

                            // запишем в сессию id пользователя
                            $_SESSION['user-id'] = $userID;

                            // отправим на главную
                            header('Location: /');
                            exit();
                        }

                    }
                }
            }
        }

        // отправим на авторизацию
        include_once ROOT.'/views/ViewAuthorisation.php';
    }

    # function actionShow
    public function actionShow() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->validateForm();

        } else {
            // если в куках есть id юзера
            if (isset($_COOKIE['user-id'])) {

                $userID = $_COOKIE['user-id'];

                // получим структуру данных юзера
                if (count($userData = ModelAuthorisation::getUserDataByID($userID)) > 0) {

                    $dbUserToken = $userData['token'];
                    $remember = $userData['remember'];
                    $userName = $userData['user_name'];

                    // если токены совпадают, то ...
                    if ($dbUserToken == $_COOKIE['user-token']) {

                        // перегенерируем все токены
                        $token = User::generateUserToken();

                        if (User::updateAllUserTokens($userID, $token, $remember)) {

                            // запишем в сессию имя пользователя
                            $_SESSION['user-name'] = $userName;

                            // запишем в сессию id пользователя
                            $_SESSION['user-id'] = $userID;

                            // отправим на главную
                            header('Location: /');
                            exit();
                        }
                    }
                }
            }

            // ... если - нет, то отправляем на promo-страницу
            include_once ROOT.'/views/ViewPromo.php';
        }
    }

    private function loadAuthorisationView() {

        // грузим ...
        include_once(ROOT . '/views/ViewAuthorisation.php');
    }
}

