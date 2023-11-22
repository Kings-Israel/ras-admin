<?php

namespace App\Helpers;

class Helpers
{
    public static function generatePassword()
    {
        $pool = ['123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'];

        $plain_password = array_rand($pool, count($pool));

        $password = bcrypt($plain_password);

        return $password;
    }
}
