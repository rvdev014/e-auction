<?php

namespace App\Enums;

enum ProductType: string
{
    case Transport = 'transports';

    public function getLabel(): string
    {
        return match ($this) {
            self::Transport => 'Транспорт',
        };
    }

    public static function values(): array
    {
        return [
            self::Transport->value,
        ];
    }

    public static function labels(): array
    {
        return [
            self::Transport->value => self::Transport->getLabel(),
        ];
    }
}
