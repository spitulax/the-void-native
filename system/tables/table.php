<?php

class Table
{
    protected static $name = 'users';

    public static function insert(array $data): array
    {
        $keys = array_keys($data);
        $columns = '';
        foreach ($keys as $i => $key) {
            if ($i > 0)
                $columns .= ', ';
            $columns .= $key;
        }

        $values = [];

        $placeholder = '';
        $i = 0;
        foreach ($data as $value) {
            if ($i > 0)
                $placeholder .= ', ';
            $placeholder .= '?';

            $type = '';
            switch ($t = gettype($value)) {
                case 'integer':
                    $type = 'i';
                    break;
                case 'double':
                    $type = 'd';
                    break;
                case 'string':
                    $type = 's';
                    break;
                default:
                    throw new Exception("Unknown type `$t`");
            }

            $values[] = [$value, $type];
            ++$i;
        }

        $user = Database::fetch(
            'INSERT INTO ' . self::$name . " ($columns) VALUES ($placeholder) RETURNING *",
            $values,
        )->fetch_assoc();
        if (!$user) {
            throw new Exception('Could not get the last inserted value');
        }
        return $user;
    }

    public static function fromId(int $id): null|array
    {
        $user = Database::fetch('SELECT * FROM ' . self::$name . ' WHERE id=?', [[$id, 'i']])->fetch_assoc();
        return $user ?: null;
    }
}
