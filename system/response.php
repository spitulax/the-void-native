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
