<?php

class Redirect
{
    protected string $target = '';
    protected array $flash = [];

    public function __construct(string $target = '', array $query = [])
    {
        if (!empty($query)) {
            $this->target = $target . '?' . http_build_query($query);
        } else {
            $this->target = $target;
        }
    }

    public function send(): void
    {
        $_SESSION['flash'] = $this->flash;
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

    public function current(): self
    {
        $this->target = static::curLoc();
        return $this;
    }

    // NOTE: Unreliable AF
    public function back(): self
    {
        $this->target = static::prevLoc();
        $this->flash['__back'] = true;
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
        $this->flash[$key] = $value;
        return $this;
    }

    public function target(): string
    {
        return $this->target;
    }

    public function flash(): array
    {
        return $this->flash;
    }
}

function redirect(string $target = '', array $query = []): Redirect
{
    return new Redirect($target, $query);
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
