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
        return ['lotable.name'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lotable_type')
                    ->label('Товар тури')
                    ->options(ProductType::labels())
                    ->afterStateUpdated(function($state, callable $get, callable $set) {
                        $set('lotable_id', null);
                    })
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('lotable_id')
                    ->label('Товар')
                    ->options(function(callable $get, callable $set) {
                        $lotableType = $get('lotable_type');
                        return match ($lotableType) {
                            ProductType::Transport->value => Transport::pluck('name', 'id'),
                            default                       => [],
                        };
                    })
                    ->required(),
                Forms\Components\DateTimePicker::make('apply_deadline')
                    ->label('Ариза қабул қилиш тугаш вақти')
                    ->required(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Аукцион бошланиш вақти')
                    ->required(),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Аукцион тугаши вақти')
                    ->required(),
                Forms\Components\TextInput::make('starting_price')
                    ->label('Бошланиш нархи (сўм)')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('deposit_amount')
                    ->label('Закалат пули фоизда')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('type')
                    ->label('Аукцион тури')
                    ->options(LotType::labels())
                    ->default(LotType::OnIncrease->value)
                    ->required(),
                Forms\Components\TextInput::make('step_amount')
                    ->label('Қадам фоизда')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_cancelled')
                    ->label('Бекор килинган'),
                Forms\Components\TextInput::make('cancel_reason')
                    ->label('Бекор қилиш сабаби')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('lot_status')
                    ->view('tables.columns.lot-status-column')
                    ->width('300px')
                    ->label('Лот холати'),
                Tables\Columns\TextColumn::make('lotable_id')
                    ->label('Товар')
                    ->formatStateUsing(fn($record) => $record->lotable?->name),
                Tables\Columns\TextColumn::make('apply_deadline')
                    ->label('Ариза қабул қилиш тугаш вақти')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Аукцион бошланиш вақти')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Аукцион тугаши вақти')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('starting_price')
                    ->label('Бошланиш нархи (сўм)')
                    ->numeric(),
                Tables\Columns\TextColumn::make('deposit_amount')
                    ->label('Закалат пули фоизда')
                    ->numeric(),
                Tables\Columns\TextColumn::make('step_amount')
                    ->label('Қадам фоизда')
                    ->numeric(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Аукцион тури')
                    ->badge(),
                /*Tables\Columns\IconColumn::make('is_cancelled')
                    ->label('Бекор килинган')
                    ->boolean(),*/
                Tables\Columns\TextColumn::make('cancel_reason')
                    ->label('Бекор қилиш сабаби')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Яратилган вақти')
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
