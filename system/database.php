<?php

class Database
{
    private const HOSTNAME = 'localhost';
    private const NAME = 'the_void_native';
    private const USERNAME = 'root';
    private const PASSWORD = 'root';

    private static null|self $instance = null;
    private mysqli $connection;

    protected function __construct()
    {
        try {
            $this->connection = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::NAME);
        } catch (\Throwable $th) {
            throw new Exception('Gagal untuk menyambungkan ke MySQL: ' . $th);
        }
    }

    protected function __clone(): void
    {
    }

    public static function get(): mysqli
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }

    public static function execute(string $query, array $args): mysqli_result
    {
        $query = self::get()->prepare($query);
        foreach ($args as $arg) {
            $query->bind_param($arg[1] ?? 's', $arg[0]);
        }
        $query->execute();
        return $query->get_result();
    }
}
