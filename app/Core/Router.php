<?php
namespace App\Core;

use App\Controllers\ErrorController;

class Router
{
    protected $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method)
    {
        $uri = strtok($uri, '?');

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            return $this->callAction($action);
        }

        // No route matched – show 404
        $controller = new ErrorController();
        $controller->notFound();
    }

    protected function callAction($action)
    {
        list($controller, $method) = explode('@', $action);
        $controller = "App\\Controllers\\{$controller}";
        $controllerInstance = new $controller();
        return $controllerInstance->$method();
    }
}