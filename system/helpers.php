<?php

function h(string $string): string
{
    return htmlspecialchars($string);
}

function get(string $key): mixed
{
    return $_GET[$key] ?? null;
}

function domain(): string
{
    $protocol =
        !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443
            ? 'https://'
            : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'];
}
