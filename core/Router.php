<?php

namespace core;

class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Creates instance of Router class and execute all get and post methods.
     */
    public static function load($path)
    {
        $router = new self;
        require $path;
        return $router;
    }

    /**
     * Stores GET request route into array.
     */
    public function get($uri, $controllerAction)
    {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    /**
     * Stores POST request route into array.
     */
    public function post($uri, $controllerAction)
    {
        $this->routes['POST'][$uri] = $controllerAction;
    }

    /**
     * Directs to exact controller's action using URI and request method.
     */
    public function direct($uri, $requestMethod)
    {
        if (array_key_exists($uri, $this->routes[$requestMethod])) {
            [$controller, $action] = explode('@', $this->routes[$requestMethod][$uri]);
            $controller = "App\Controllers\\$controller";
            try {
                return $this->callAction($controller, $action);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * Executes controller's action.
     */
    public function callAction($controller, $action)
    {
        $controller = new $controller;
        if (!method_exists($controller, $action)) {
            throw new \Exception('No such action - ' . $action . ' - in controller');
        } else {
            return $controller->$action();
        }
    }
}