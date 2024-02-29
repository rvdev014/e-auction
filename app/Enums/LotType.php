<?php

namespace App\Enums;

enum LotType: int
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
}
