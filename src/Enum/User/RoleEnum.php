<?php

namespace App\Enum\User;

class RoleEnum
{
    const ROLE_1 = 'ROLE_1';
    const ROLE_2 = 'ROLE_2';

    public static array $roles = [
        self::ROLE_1 => 'R1',
        self::ROLE_2 => 'R2',
    ];

    public static function getRole($key): string
    {
        if (!isset(static::$roles[$key])) {
            return "ROLE_USER";
        }

        return static::$roles[$key];
    }

    public static function getChoices(): array
    {
        return array_flip(static::$roles);
    }
}
