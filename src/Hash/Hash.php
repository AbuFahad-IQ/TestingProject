<?php

namespace Src\Hash;

class Hash
{
    public static function bcrypt($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function make($token): string
    {
        return sha1($token . time());
    }
}
