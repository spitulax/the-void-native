<?php

class Auth
{
    private static null|self $instance = null;
    private null|array $user = null;

    protected function __construct()
    {
        if (!$this->user && isset($_SESSION['user_id'])) {
            $this->user = UserTable::fromId(intval($_SESSION['user_id']));
        }
    }

    protected function __clone(): void
    {
    }

    public static function get(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function login(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $this->user = $user;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        $this->user = null;
        session_unset();
        session_destroy();
    }

    public static function user(): null|array
    {
        return self::get()->user ?? null;
    }
}
