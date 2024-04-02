<?php

namespace App\Filament\Resources\UserUpdateRequestResource\Pages;

use App\Filament\Resources\UserUpdateRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserUpdateRequests extends ListRecords
{
    protected static string $resource = UserUpdateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
