<?php

require_once 'system/database.php';
require_once 'system/table.php';

class PostTable extends Table
{
    protected static string $name = 'posts';

    public static function author(int $id): null|array
    {
        $res = self::fromIdJoin($id, 'users', 'author_id')->fetch_assoc();
        return $res ?: null;
    }

    public static function canView(array $post): bool
    {
        $user = Auth::user();
        $author = static::author($post['id']);
        if ($post['private'] !== 1) {
            return true;
        }
        if ($user && $user['admin']) {
            return true;
        } elseif ($user && $author) {
            return $user['id'] === $author['id'];
        } else {
            return false;
        }
    }

    public static function allCanView(): mysqli_result
    {
        $user = Auth::user();
        $args = [];
        $whenPrivate = '';
        if ($user && $user['admin']) {
            $whenPrivate = 'TRUE';
        } elseif ($user) {
            $whenPrivate = 'u.id=?';
            $args[] = [$user['id'], 'i'];
        } else {
            $whenPrivate = 'FALSE';
        }
        return Database::fetch("
            SELECT p.*
            FROM posts p
            LEFT JOIN users u
            ON p.author_id=u.id
            WHERE
            (CASE
                WHEN p.private=1 THEN {$whenPrivate}
                ELSE TRUE
            END)
            ", $args);
    }
}
