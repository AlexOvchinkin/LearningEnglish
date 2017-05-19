<?php

class Router {

    public function run() {

        $uri = $_SERVER['REQUEST_URI'];
        $routes = include_once ROOT.'/Routes.php';
        $notFound = true;

        foreach ($routes as $path => $route) {
            if (preg_match("~$path~", $uri) === 1) {
                $routeString = trim(preg_replace("~$path~", $route, $uri), '/');
                $routeArray = explode('/', $routeString);
                $controllerName = array_shift($routeArray);
                $controller = new $controllerName();

                call_user_func_array(array($controller, 'actionShow'), $routeArray);
                $notFound = false;
                break;
            }
        }

        if ($notFound) {
            header("Location: /404");
            exit();
        }
    }
}