<?php

namespace App\Enums;

enum LotStatus: int
{
    case Cancelled = 0;
    case Active = 1;
    case Ended = 2;

    public static function labels(): array
    {
        return [
            self::Cancelled->value => self::Cancelled->getLabel(),
            self::Active->value => self::Active->getLabel(),
            self::Ended->value => self::Ended->getLabel(),
        ];
    }


    public function getLabel(): string
    {
        return match ($this) {
            self::Cancelled => 'Отменен',
            self::Active => 'Активен',
            self::Ended => 'Завершен',
        };
    }
}
