<?php

require_once 'system/database.php';
require_once 'system/tables/table.php';

class UserTable extends Table
{
    protected static $name = 'users';

    public static function match(string $username, string $password): null|array
    {
        $match = Database::execute('SELECT * FROM users WHERE username=?', [[$username, 's']])->fetch_assoc();
        if ($match && password_verify($password, $match['password'])) {
            return $match;
        } else {
            return null;
        }
    }
}
