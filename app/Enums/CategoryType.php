<?php

namespace App\Enums;

enum CategoryType:int
{
    case Auto = 1;
    case Other = 2;

    public static function labels(): array
    {
        return [
            self::Auto->value => self::Auto->getLabel(),
            self::Other->value => self::Other->getLabel(),
        ];
    }


    public function getLabel(): string
    {
        return match ($this) {
            self::Auto  => 'Автотранспорт',
            self::Other => 'Другое',
        };
    }

    public static function values(): array
    {
        return [
            self::Auto->value,
            self::Other->value,
        ];
    }
}
