<?php

require_once 'system/database.php';

class UserTable
{
    public static function match(string $username, string $password): null|array
    {
        $match = Database::execute('SELECT * FROM users WHERE username=? LIMIT 1', [[$username, 's']])->fetch_assoc();
        if ($match && password_verify($password, $match['password'])) {
            return $match;
        } else {
            return null;
        }
    }
}
