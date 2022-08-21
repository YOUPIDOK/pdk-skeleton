<?php

namespace App\Entity\User;

class GenderEnum
{
    const MAN = 'MAN';
    const WOMAN = 'WOMAN';
    const NON_BINARY = 'NON_BINARY';

    public static array $genders = [
        self::MAN => 'Homme',
        self::WOMAN => 'Femme',
        self::NON_BINARY => 'Non-binaire',
    ];

    public static array $prefixs = [
        self::MAN => 'M.',
        self::WOMAN => 'Mme',
        self::NON_BINARY => '',
    ];

    public static function getGender($key): string
    {
        if (!isset(static::$genders[$key])) {
            return "Genre inconnu ($key)";
        }

        return static::$genders[$key];
    }

    public static function getPrefix($key): ?string
    {
        if (!isset(static::$prefixs[$key])) {
            return "Genre inconnu ($key)";
        }

        return static::$prefixs[$key];
    }

    public static function getChoices(): array
    {
        return array_flip(static::$genders);
    }
}
