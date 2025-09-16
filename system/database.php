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
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->connection = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::NAME);
        } catch (Throwable $th) {
            throw new Exception('Failed to connect to MySQL: ' . $th);
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

    public static function execute(string $query, array $args = []): void
    {
        $query = self::get()->prepare($query);
        foreach ($args as $arg) {
            $query->bind_param($arg[1] ?? 's', $arg[0]);
        }
        $query->execute();
    }

    public static function fetch(string $query, array $args = []): mysqli_result
    {
        $types = '';
        $values = [];
        foreach ($args as $arg) {
            $types .= $arg[1] ?? 's';
            $values[] = $arg[0];
        }

        $query = self::get()->prepare($query);

        $query->bind_param($types, ...array_map(fn(&$v) => $v, $values));
        $query->execute();
        return $query->get_result();
    }
}
