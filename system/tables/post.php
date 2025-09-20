<?php

require_once 'system/database.php';
require_once 'system/table.php';

class PostTable extends AuthoredTable
{
    protected static string $name = 'posts';
    protected static string $authorTable = 'users';

    public static function userLiked(int $id, null|int $userId): bool
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM likes l
            INNER JOIN users u ON l.user_id=u.id
            INNER JOIN posts p ON l.post_id=p.id
            WHERE p.id=? AND u.id=?
            ', [[$id, 'i'], [$userId, 'i']])->fetch_assoc();
        return $res ? $res['count'] > 0 : false;
    }

    public static function likes(int $id): int
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM likes l
            INNER JOIN users u ON l.user_id=u.id
            INNER JOIN posts p ON l.post_id=p.id
            WHERE p.id=?
            ', [[$id, 'i']])->fetch_assoc();
        return $res ? intval($res['count']) : 0;
    }

    public static function getReplies(int $id): mysqli_result
    {
        return Database::fetch('
            SELECT r.*
            FROM posts r
            INNER JOIN posts p ON r.parent_id=p.id
            WHERE p.id=?;
            ', [[$id, 'i']]);
    }

    public static function replies(int $id): int
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM posts r
            INNER JOIN posts p ON r.parent_id=p.id
            WHERE p.id=?
            ', [[$id, 'i']])->fetch_assoc();
        return $res ? intval($res['count']) : 0;
    }

    public static function canView(array $post, null|array $user): bool
    {
        if ($post['private'] !== 1) {
            return true;
        }
        return static::owns($post['id'], $user);
    }

    public static function allCanView(null|array $user, bool $excludeReplies = true): mysqli_result
    {
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

        $whenExcludeReplies = 'TRUE';
        if ($excludeReplies) {
            $whenExcludeReplies = 'p.parent_id IS NULL';
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
                AND
                {$whenExcludeReplies}
            ", $args);
    }

    public static function canDelete(int $id, null|array $user): bool
    {
        return static::owns($id, $user);
    }

    public static function canEdit(int $id, null|array $user): bool
    {
        return static::owns($id, $user);
    }
}
