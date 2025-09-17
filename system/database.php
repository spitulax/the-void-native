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
            $this->connection = mysqli_connect(static::HOSTNAME, static::USERNAME, static::PASSWORD, static::NAME);
        } catch (Throwable $th) {
            throw new Exception('Failed to connect to MySQL: ' . $th);
        }
    }

    protected function __clone(): void
    {
    }

    public static function get(): mysqli
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance->connection;
    }

    public static function execute(string $query, array $args = []): mysqli_stmt
    {
        $types = '';
        $values = [];
        foreach ($args as $arg) {
            $types .= $arg[1] ?? 's';
            $values[] = $arg[0];
        }

        $query = static::get()->prepare($query);

        if (!empty($values)) {
            $query->bind_param($types, ...$values);
        }

        if (!$query->execute()) {
            throw new Exception("Failed to run SQL query `$query`");
        }

        return $query;
    }

    public static function fetch(string $query, array $args = []): mysqli_result
    {
        return static::execute($query, $args)->get_result();
    }
}
