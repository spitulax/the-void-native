<?php

class Redirect
{
    public function __construct(
        protected string $target = '',
    ) {}

    public function send(): void
    {
        header('Location: ' . $this->target);
        exit();
    }

    public static function curLoc(): string
    {
        return $_SESSION['current_loc'];
    }

    public static function prevLoc(): string
    {
        return $_SESSION['previous_loc'];
    }

    public static function intendedDest(): string
    {
        return $_SESSION['intended_dest'] ?? '';
    }

    public function back(): self
    {
        $this->target = static::prevLoc();
        $_SESSION['flash']['__back'] = true;
        return $this;
    }

    public static function markIntendedDest(string $target): void
    {
        $_SESSION['intended_dest'] = $target;
    }

    public static function markCurLoc(): void
    {
        static::markIntendedDest(static::curLoc());
    }

    public static function markLastLoc(): void
    {
        if (!flash('__back')) {
            static::markIntendedDest(static::prevLoc());
        }
    }

    public function intended(string $fallback = '/'): self
    {
        $intended = static::intendedDest();
        $this->target = !empty($intended) ? $intended : $fallback;
        unset($_SESSION['intended_dest']);
        return $this;
    }

    public function with(string $key, mixed $value): self
    {
        $_SESSION['flash'][$key] = $value;
        return $this;
    }
}

function redirect(string $target = ''): Redirect
{
    return new Redirect($target);
}

function flash(string $key): mixed
{
    if (isset($_SESSION['flash'][$key])) {
        $value = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $value;
    }
    return null;
}
