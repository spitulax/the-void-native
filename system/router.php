<?php

require_once 'redirect.php';

class Router
{
    private array $routes = [];

    private static function normalize(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        return rtrim($path, '/') ?: '/';
    }

    public function add(string $method, string $path, callable $handler): void
    {
        $method = strtoupper($method);
        $path = $this->normalize($path);
        $this->routes[$method][$path] = $handler;
    }

    public function get(string $path, callable $handler): void
    {
        $this->add('get', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->add('post', $path, $handler);
    }

    public function page(string $path, null|string $page = null): void
    {
        $actualPage = 'pages/' . ($page ?: $path);
        $actualPath = $page ? $path : ('/' . $path);
        $this->get($actualPath, function () use ($actualPage) {
            require $actualPage;
        });
    }

    public function dispatch(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $uri = self::normalize(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $routes = $this->routes[$method] ?? [];

        if (isset($routes[$uri])) {
            $data = match ($method) {
                'GET' => $_GET,
                'POST' => $_POST,
                default => [],
            };

            $result = call_user_func($routes[$uri], $data);

            if ($result instanceof Redirect) {
                $result->send();
            } elseif (is_string($result)) {
                echo $result;
            }
        } else {
            http_response_code(404);
            require 'pages/404.php';
        }
    }
}
