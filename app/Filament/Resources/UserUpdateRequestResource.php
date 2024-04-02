<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\UserUpdateRequest;
use App\Filament\Resources\UserUpdateRequestResource\Pages;
use App\Filament\Resources\UserUpdateRequestResource\RelationManagers;

class UserUpdateRequestResource extends Resource
{
    protected static ?string $model = UserUpdateRequest::class;
    protected static ?string $pluralLabel = 'Фойдаланувчи маълумотлари янгилаш';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'phone')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('data')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->formatStateUsing(function($record) {
                        return $record->user->name . ' (' . $record->user->phone . ')';
                    })
                    ->label('Фойдаланувчи'),
                /*Tables\Columns\TextColumn::make('status')
                    ->badge(),*/
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Суровнома яратилган сана')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Суровнома янгиланган сана')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserUpdateRequests::route('/'),
            'create' => Pages\CreateUserUpdateRequest::route('/create'),
            'edit' => Pages\EditUserUpdateRequest::route('/{record}/edit'),
        ];
    }
}
