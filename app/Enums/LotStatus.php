<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum LotStatus:int implements HasLabel, HasColor, HasIcon
{
    case Active = 1;
    case Ended = 2;
    case Cancelled = 0;

    public static function labels(): array
    {
        return [
            self::Active->value => self::Active->getLabel(),
            self::Ended->value => self::Ended->getLabel(),
            self::Cancelled->value => self::Cancelled->getLabel(),
        ];
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active    => 'Фаол',
            self::Ended     => 'Савдоси тугаган',
            self::Cancelled => 'Бекор қилинган',
        };
    }

    public static function valueStr(): string
    {
        return implode(',', self::values());
    }


    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active    => 'success',
            self::Ended     => 'gray',
            self::Cancelled => 'danger',
        };
    }

    public static function values(): array
    {
        return [
            self::Active->value,
            self::Ended->value,
            self::Cancelled->value,
        ];
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active    => 'heroicon-o-check-circle',
            self::Ended     => '',
            self::Cancelled => 'heroicon-o-x-circle',
        };
    }
}
