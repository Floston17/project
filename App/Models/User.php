<?php

namespace App\Models;

use App\Model;

class User extends Model
{
    protected const TABLE = 'users';
    public int $id;
    public string $name;
    public string $email;
    public string $city;
    public string $password;
    public int $admin;

    /**
     * Creates instance of User class
     */
    public static function create($name, $email, $city, $password)
    {
        $user = new self;
        $user->name = $name;
        $user->email = $email;
        $user->city = $city;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        return $user;
    }
}