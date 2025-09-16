<?php

class Table
{
    protected static $name;

    public static function fromId(int $id): null|array
    {
        $user = Database::execute('SELECT * FROM users WHERE id=?', [[$id, 'i']])->fetch_assoc();
        return $user ?: null;
    }
}
