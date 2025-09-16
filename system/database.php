<?php

class Database
{
    private const HOSTNAME = 'localhost';
    private const NAME = 'the_void_native';
    private const USERNAME = 'root';
    private const PASSWORD = 'root';

    private static null|Database $instance = null;
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
}
