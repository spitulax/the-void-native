<?php

function h(string $string): string
{
    return htmlspecialchars($string);
}

function get(string $key): mixed
{
    return $_GET[$key] ?? null;
}
