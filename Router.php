<?php

class Router {

    public function run() {

        $uri = $_SERVER['REQUEST_URI'];

        // если пользователь авторизован
        if (preg_match('/^(registration)$/', trim($uri, '/'))
            || preg_match('/^(authorisation)$/', trim($uri, '/'))
            || User::isAuthorized()) {

            $routes = include_once ROOT . '/Routes.php';
            $notFound = true;

            foreach ($routes as $path => $route) {
                if (preg_match("~$path~", $uri) === 1) {
                    $routeString = trim(preg_replace("~$path~", $route, $uri), '/');
                    $routeArray = explode('/', $routeString);
                    $controllerName = array_shift($routeArray);
                    $controller = new $controllerName();
                    $actionName = array_shift($routeArray);

                    call_user_func_array(array($controller, $actionName), $routeArray);
                    $notFound = false;
                    break;
                }
            }

            if ($notFound) {
                header("Location: /404");
                exit();
            }
        } else {

            // если - нет, то - на страницу авторизации
            $authorisation = new ControllerAuthorisation();
            $authorisation->actionShow();
        }
    }
}