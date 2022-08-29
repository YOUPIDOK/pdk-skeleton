<?php

namespace App\Enum\User;

class RoleEnum
{
    const DEFAULT_ROLE = 'ROLE_USER';

    const ROLE_TEST_1 = 'ROLE_TEST_1';
    const ROLE_TEST_2 = 'ROLE_TEST_2';

    public static array $roles = [
        self::ROLE_TEST_1 => 'Accès test n°1',
        self::ROLE_TEST_2 => 'Accès test n°2',
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
