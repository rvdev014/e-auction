<?php

namespace App\Enums;

enum UserUpdateRequestStatus:int
{
    case Pending = 1;
    case Approved = 2;
    case Cancelled = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending   => 'Pending',
            self::Approved  => 'Approved',
            self::Cancelled => 'Cancelled',
        };
    }

    public static function values(): array
    {
        return [
            self::Pending->value,
            self::Approved->value,
            self::Cancelled->value,
        ];
    }
}
