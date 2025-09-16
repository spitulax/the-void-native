<?php

class Redirect
{
    protected string $target;

    public function __construct(string $target = '')
    {
        $this->target = $target;
    }

    public function send(): void
    {
        header('Location: ' . $this->target);
        exit();
    }

    public static function curLoc(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function lastLoc(): null|string
    {
        return $_SERVER['HTTP_REFERER'] ?? null;
    }

    public function back(string $fallback = '/'): self
    {
        $this->target = self::lastLoc() ?? $fallback;
        $_SESSION['flash']['__back'] = true;
        return $this;
    }

    public static function markIntendedDest(string $target): void
    {
        $_SESSION['intended_dest'] = $target;
    }

    public static function markLastLoc(): void
    {
        if (!flash('__back')) {
            self::markIntendedDest(self::lastLoc() ?? '/');
        }
    }

    public function intended(string $fallback = '/'): self
    {
        $this->target = $_SESSION['intended_dest'] ?? $fallback;
        unset($_SESSION['intended_dest']);
        return $this;
    }

    public function with(string $key, $value): self
    {
        $_SESSION['flash'][$key] = $value;
        return $this;
    }
}

function redirect(string $target = ''): Redirect
{
    return new Redirect($target);
}

function flash(string $key): null|string
{
    if (isset($_SESSION['flash'][$key])) {
        $value = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $value;
    }
    return null;
}
