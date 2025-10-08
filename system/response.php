<?php

require_once 'system/redirect.php';

class Response
{
    public static function accept(string $text): void
    {
        die($text);
    }

    public static function notFound(): void
    {
        http_response_code(404);
        redirect('/404.php')->send();
    }

    public static function login(): void
    {
        Redirect::markCurLoc();
        redirect('/login.php')->send();
    }
}

class JsonResponse
{
    public static function data(mixed $data): void
    {
        header('Content-Type: application/json');
        die(json_encode($data));
    }

    public static function error(mixed $data): void
    {
        header('Content-Type: application/json');
        http_response_code(400);
        die(json_encode(['error' => $data]));
    }

    public static function unauthorized(): void
    {
        http_response_code(401);
        die('Unauthorized');
    }
}
