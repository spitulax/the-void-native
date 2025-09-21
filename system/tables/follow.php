<?php

require_once 'system/table.php';

class FollowTable extends Table
{
    protected static string $name = 'follows';

    public static function addFollow(int $followedId, int $followerId): void
    {
        parent::insert(['follower_id' => $followerId, 'followed_id' => $followedId]);
    }

    public static function removeFollow(int $followedId, int $followerId): void
    {
        Database::execute('
            DELETE FROM follows
            WHERE follower_id=? AND followed_id=?
            ', [[$followerId, 'i'], [$followedId, 'i']]);
    }
}
