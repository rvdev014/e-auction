<?php

namespace App\Filament\Resources;

use App\Models\Lot;
use Filament\Forms;
use Filament\Tables;
use App\Enums\LotType;
use Filament\Forms\Form;
use App\Models\Transport;
use Filament\Tables\Table;
use App\Enums\ProductType;
use Filament\Resources\Resource;
use App\Filament\Resources\LotResource\Pages;
use App\Filament\Resources\LotResource\RelationManagers;

class LotResource extends Resource
{
    protected static ?string $model = Lot::class;
    protected static ?string $pluralLabel = 'Лотлар';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Аукцион тури')
                    ->options(LotType::labels())
                    ->default(LotType::OnIncrease->value)
                    ->required(),
                Forms\Components\Select::make('lotable_type')
                    ->label('Товар тури')
                    ->options(ProductType::labels())
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('lotable_id', null);
                    })
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('lotable_id')
                    ->label('Товар')
                    ->options(function (callable $get, callable $set) {
                        $lotableType = $get('lotable_type');
                        return match ($lotableType) {
                            ProductType::Transport->value => Transport::pluck('name', 'id'),
                            default => [],
                        };
                    })
                    ->required(),
                Forms\Components\DateTimePicker::make('apply_deadline')
                    ->required(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->required(),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->required(),
                Forms\Components\TextInput::make('starting_price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('deposit_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('step_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cancel_reason')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lotable_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lotable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apply_deadline')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('starting_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deposit_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('step_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cancel_reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListLots::route('/'),
            'create' => Pages\CreateLot::route('/create'),
            'edit' => Pages\EditLot::route('/{record}/edit'),
        ];
    }
}
