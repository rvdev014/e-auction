<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum PaymentType: int implements HasLabel, HasColor, HasIcon
{
    case Income = 1;
    case Expense = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::Income => 'Кирим',
            self::Expense => 'Чиқим',
        };
    }

    public static function values(): array
    {
        return [
            self::Income->value,
            self::Expense->value,
        ];
    }

    public static function labels(): array
    {
        return [
            self::Income->value => self::Income->getLabel(),
            self::Expense->value => self::Expense->getLabel(),
        ];
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Income => 'success',
            self::Expense => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Income => 'heroicon-o-currency-dollar',
            self::Expense => 'heroicon-o-currency-euro',
        };
    }
}
