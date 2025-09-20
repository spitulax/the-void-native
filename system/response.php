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
    public static function data(array $data): void
    {
        header('Content-Type: application/json');
        die(json_encode($data));
    }

    public static function redirect(Redirect $redirect): void
    {
        header('Content-Type: application/json');
        die(json_encode([
            'redirect' => $redirect->target(),
            'flash' => $redirect->flash(),
        ]));
    }

    public static function login(): void
    {
        Redirect::markCurLoc();
        static::redirect(redirect('/login.php'));
    }
}
