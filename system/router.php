<?php

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $method = strtoupper($method);
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if ($uri === '') {
            $uri = '/';
        }

        $routes = $this->routes[$method] ?? [];

        if (isset($routes[$uri])) {
            call_user_func($routes[$uri]);
        } else {
            http_response_code(404);
            require ROOT . '/pages/404.php';
        }
    }
}
