<?php

require_once 'system/table.php';

class LikeTable extends Table
{
    protected static string $name = 'likes';

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

    public static function addLike(int $id, int $userId): void
    {
        parent::insert(['user_id' => $userId, 'post_id' => $id]);
    }

    public static function removeLike(int $id, int $userId): void
    {
        Database::execute('
            DELETE FROM likes
            WHERE post_id=? AND user_id=?
            ', [[$id, 'i'], [$userId, 'i']]);
    }
}
