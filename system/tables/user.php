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

    public static function userFollowed(int $id, null|int $userId): bool
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM follows f
            INNER JOIN users fr ON f.follower_id=fr.id
            INNER JOIN users fd ON f.followed_id=fd.id
            WHERE fd.id=? AND fr.id=?
            ', [[$id, 'i'], [$userId, 'i']])->fetch_assoc();
        return $res ? $res['count'] > 0 : false;
    }

    public static function follows(int $id): int
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM follows f
            INNER JOIN users fr ON f.follower_id=fr.id
            INNER JOIN users fd ON f.followed_id=fd.id
            WHERE fd.id=?
            ', [[$id, 'i']])->fetch_assoc();
        return $res ? intval($res['count']) : 0;
    }

    public static function getFollows(int $id): mysqli_result
    {
        return Database::fetch('
            SELECT fr.*
            FROM follows f
            INNER JOIN users fr ON f.follower_id=fr.id
            INNER JOIN users fd ON f.followed_id=fd.id
            WHERE fd.id=?
            ', [[$id, 'i']]);
    }

    public static function delete(int $id): void
    {
        $res = Database::fetch('
            SELECT p.id
            FROM posts p
            INNER JOIN users u
            ON p.author_id=u.id
            WHERE u.id=? AND p.private=1
            ', [[$id, 'i']]);
        $privatePosts = [];
        while ($post = $res->fetch_assoc()) {
            PostTable::delete($post['id']);
        }

        parent::delete($id);
    }

    public static function owns(int $id, null|array $user): bool
    {
        if ($user && $user['admin']) {
            return true;
        } elseif ($user) {
            return $user['id'] === $id;
        } else {
            return false;
        }
    }

    public static function canEdit(int $id, null|array $user): bool
    {
        return static::owns($id, $user);
    }

    public static function canDelete(int $id, null|array $user): bool
    {
        return static::owns($id, $user);
    }

    public static function canFollow(int $id, null|int $userId): bool
    {
        return $userId && $id !== $userId;
    }
}
