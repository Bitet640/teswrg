<?php

class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch() {
        // Priority 1: Use 'url' query parameter if provided by .htaccess (Standard MVC)
        if (isset($_GET['url'])) {
            $path = $_GET['url'];
        } else {
            // Priority 2: Fallback manual parsing
            $script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            
            // Clean script_dir
            if (strpos($request_uri, $script_dir) === 0) {
                $path = substr($request_uri, strlen($script_dir));
            } else {
                $path = $request_uri;
            }
        }

        $path = '/' . trim($path, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method][$path])) {
            $controllerAction = explode('@', $this->routes[$method][$path]);
            $controllerName = $controllerAction[0];
            $actionName = $controllerAction[1];

            require_once CONTROLLER_PATH . $controllerName . '.php';
            $controller = new $controllerName();
            $controller->$actionName();
        } else {
            // Simple 404
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
