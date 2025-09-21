<?php

require_once 'system/table.php';

class LikeTable extends Table
{
    protected static string $name = 'likes';

    public static function addLike(int $postId, int $userId): void
    {
        parent::insert(['user_id' => $userId, 'post_id' => $postId]);
    }

    public static function removeLike(int $postId, int $userId): void
    {
        Database::execute('
            DELETE FROM likes
            WHERE post_id=? AND user_id=?
            ', [[$postId, 'i'], [$userId, 'i']]);
    }
}
