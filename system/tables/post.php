<?php

require_once 'system/table.php';

class PostTable extends Table
{
    protected static string $name = 'posts';

    public static function author(int $id): null|array
    {
        $res = self::fromIdJoin($id, 'users', 'author_id')->fetch_assoc();
        return $res ?: null;
    }
}
