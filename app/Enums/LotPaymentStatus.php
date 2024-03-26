<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum LotPaymentStatus:int implements HasLabel, HasColor, HasIcon
{
    case Paid = 1;
    case NotPaid = 0;

    public static function labels(): array
    {
        return [
            self::Paid->value => self::Paid->getLabel(),
            self::NotPaid->value => self::NotPaid->getLabel(),
        ];
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Paid    => 'Тўланган',
            self::NotPaid => 'Тўланмаган',
        };
    }

    public static function valueStr(): string
    {
        return implode(',', self::values());
    }


    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Paid    => 'success',
            self::NotPaid => 'danger',
        };
    }

    public static function values(): array
    {
        return [
            self::Paid->value,
            self::NotPaid->value,
        ];
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Paid    => 'heroicon-o-check-circle',
            self::NotPaid => 'heroicon-o-x-circle',
        };
    }
}
