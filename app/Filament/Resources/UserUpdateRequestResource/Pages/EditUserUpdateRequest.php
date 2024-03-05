<?php

namespace App\Filament\Resources\UserUpdateRequestResource\Pages;

use App\Filament\Resources\UserUpdateRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserUpdateRequest extends EditRecord
{
    protected static string $resource = UserUpdateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
