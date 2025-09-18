<?php

require_once 'system/database.php';
require_once 'system/table.php';

class UserTable extends Table
{
    protected static string $name = 'users';

    public static function match(string $username, string $password): null|array
    {
        $match = Database::fetch('SELECT * FROM ' . static::$name . ' WHERE username=?', [[
            $username,
            's',
        ]])->fetch_assoc();
        if ($match && password_verify($password, $match['password'])) {
            return $match;
        } else {
            return null;
        }
    }
}
