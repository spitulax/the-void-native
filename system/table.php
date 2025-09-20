<?php

require_once 'system/database.php';

class Table
{
    protected static string $name;

    public static function all(): mysqli_result
    {
        return Database::fetch('SELECT * FROM ' . static::$name);
    }

    public static function fromId(int $id): null|array
    {
        $res = Database::fetch('SELECT * FROM ' . static::$name . ' WHERE id=?', [[$id, 'i']])->fetch_assoc();
        return $res ?: null;
    }

    public static function fromIdJoin(int $id, string $table, string $foreignId, string $otherId = 'id'): mysqli_result
    {
        $name = static::$name;
        return Database::fetch(
            "
            SELECT b.*
            FROM $name a
            INNER JOIN $table b
            ON a.{$foreignId}=b.{$otherId}
            WHERE a.id=?
            ",
            [[$id, 'i']],
        );
    }

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
        foreach ($data as &$value) {
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
                case 'boolean':
                    $type = 'i';
                    $value = $value ? 1 : 0;
                    break;
                default:
                    throw new Exception("Unknown type `$t`");
            }

            $values[] = [$value, $type];
            ++$i;
        }

        $res = Database::fetch(
            'INSERT INTO ' . static::$name . " ($columns) VALUES ($placeholder) RETURNING *",
            $values,
        )->fetch_assoc();
        if (!$res) {
            throw new Exception('Could not get the last inserted value');
        }
        return $res;
    }

    public static function delete(int $id): void
    {
        Database::execute('DELETE FROM ' . static::$name . ' WHERE id=?', [[$id, 'i']]);
    }

    public static function deleteWhere(string $column, string $op, array $value): void
    {
        Database::execute('DELETE FROM ' . static::$name . " WHERE {$column}{$op}?", [$value]);
    }
}

class AuthoredTable extends Table
{
    protected static string $authorTable;

    public static function author(int $id): null|array
    {
        $res = static::fromIdJoin($id, static::$authorTable, 'author_id')->fetch_assoc();
        return $res ?: null;
    }

    public static function owns(int $id, null|array $user): bool
    {
        $author = static::author($id);
        if ($user && $user['admin']) {
            return true;
        } elseif ($user && $author) {
            return $user['id'] === $author['id'];
        } else {
            return false;
        }
    }
}
