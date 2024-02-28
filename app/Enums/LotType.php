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
}
