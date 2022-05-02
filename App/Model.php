<?php

namespace App;

use App\Exceptions\EmailException;
use core\Container;

abstract class Model
{
    protected const TABLE = '';

    /**
     * Selects all records.
     */
    public static function selectAll(): array
    {
        $statement = 'SELECT * FROM ' . static::TABLE;
        return Container::get('database')->query($statement, static::class);
    }

    /**
     * Finds record by email
     */
    public static function findByEmail(string $email): object
    {
        $statement = 'SELECT * FROM ' . static::TABLE . ' WHERE email=:email';
        $user = Container::get('database')->query($statement, static::class, [':email' => $email]);
        if ($user) {
            return $user[0];
        } else {
            throw new EmailException('This email is not registered!');
        }
    }

    /**
     * Finds records by column value
     */
    public static function findByColumn(string $column, string $value): array
    {
        $statement = 'SELECT * FROM ' . static::TABLE . ' WHERE ' . $column . '=:' . $column;
        return Container::get('database')->query($statement, static::class, [':' . $column => $value]);
    }

    /**
     * Inserts record into the table
     */
    public function insert(): bool
    {
        $data = [];
        $props = get_object_vars($this);

        if (array_key_exists('id', $props)) {
            unset($props['id']);
        }

        $statement = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            static::TABLE,
            implode(', ', array_keys($props)),
            ':' . implode(', :', array_keys($props))
        );

        foreach ($props as $key => $value) {
            $data[':' . $key] = $value;
        }

        $res = Container::get('database')->execute($statement, $data);
        if (static::TABLE == 'users') {
            $this->id = Container::get('database')->lastInsertId();
            if (!array_key_exists('admin', $props)) {
                $this->admin = 0;
            }
        }
        return $res;
    }

    /**
     * Updates record
     */
    public function update(): bool
    {
        $data = [];
        $columns = [];
        $props = get_object_vars($this);

        if (array_key_exists('id', $props)) {
            unset($props['id']);
        }

        foreach ($props as $key => $value) {
            $columns[] = $key . '=:' . $key;
            $data[':' . $key] = $value;
        }
        $data[':id'] = $this->id;

        $statement = 'UPDATE ' . static::TABLE . ' SET ' . implode(', ', $columns) . ' WHERE id=:id';

        $res = Container::get('database')->execute($statement, $data);
        return $res;
    }

    /**
     * Deletes records by column value
     */
    public static function deleteByColumn(string $column, string $value): bool
    {
        $statement = 'DELETE FROM ' . static::TABLE . ' WHERE ' . $column . '=:' . $column;
        $data[':' . $column] = $value;
        return Container::get('database')->execute($statement, $data);
    }
}