<?php

require_once 'system/table.php';

class NotifTable extends Table
{
    protected static string $name = 'notifs';

    public static function count(int $userId): int
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM notifs
            WHERE recipient_id=?
            ', [[$userId, 'i']])->fetch_assoc();
        return $res['count'] ?? 0;
    }

    public static function unreadCount(int $userId): int
    {
        $res = Database::fetch('
            SELECT COUNT(*) AS count
            FROM notifs
            WHERE recipient_id=? AND viewed=0
            ', [[$userId, 'i']])->fetch_assoc();
        return $res['count'] ?? 0;
    }

    public static function getNotifs(int $userId): mysqli_result
    {
        return Database::fetch('
            SELECT * FROM notifs
            WHERE recipient_id=?
            ORDER BY id DESC
            ', [[$userId, 'i']]);
    }

    public static function clearAll(int $userId): void
    {
        static::deleteWhere('recipient_id', '=', [$userId, 'i']);
    }
}
