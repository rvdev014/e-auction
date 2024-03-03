<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum LotType: int implements HasLabel, HasColor, HasIcon
{
    case OnIncrease = 1;
    case OnDecrease = 2;
    case FreeSale = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::OnIncrease => 'На повышение',
            self::OnDecrease => 'На понижение',
            self::FreeSale => 'Свободная продажа',
        };
    }

    public static function values(): array
    {
        return [
            self::OnIncrease->value,
            self::OnDecrease->value,
            self::FreeSale->value,
        ];
    }

    public static function labels(): array
    {
        return [
            self::OnIncrease->value => self::OnIncrease->getLabel(),
            self::OnDecrease->value => self::OnDecrease->getLabel(),
            self::FreeSale->value => self::FreeSale->getLabel(),
        ];
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OnIncrease => 'success',
            self::OnDecrease => 'danger',
            self::FreeSale => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::OnIncrease => '',
            self::OnDecrease => '',
            self::FreeSale => '',
        };
    }
}
