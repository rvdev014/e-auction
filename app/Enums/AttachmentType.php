<?php

namespace App\Enums;

enum AttachmentType: int
{
    case Document = 1;
    case Media = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::Document => 'Document',
            self::Media => 'Media'
        };
    }
}
