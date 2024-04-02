<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\PaymentType;
use Filament\Resources\Resource;
use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Фойдаланувчи')
                    ->native(false)
                    ->reactive()
                    ->relationship('user', 'phone')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Миқдор')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Кирим / Чиқим')
                    ->native(false)
                    ->default(PaymentType::Expense->value)
                    ->options(PaymentType::labels()),
                Forms\Components\Textarea::make('comment')
                    ->label('Изоҳ'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Фойдаланувчи'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Миқдор')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Кирим / Чиқим')
                    ->badge(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Изоҳ'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Сана')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
        ];
    }
}
