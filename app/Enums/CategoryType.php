<?php

namespace App\Enums;

enum CategoryType: int
{
    case Auto = 1;
    case Other = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::Auto => 'Автотранспорт',
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
