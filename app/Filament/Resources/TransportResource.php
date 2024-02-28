<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transport;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\TransportResource\Pages;
use App\Filament\Resources\TransportResource\RelationManagers;

class TransportResource extends Resource
{
    protected static ?string $model = Transport::class;
    protected static ?string $pluralLabel = 'Автотранспорт';
    protected static ?string $navigationIcon = 'heroicon-m-truck';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'owner', 'car_number'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Номи')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('owner')
                        ->label('Автотранспорт эгаси')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('car_number')
                        ->label('Давлат рақами')
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('year_of_issue')
                        ->label('Ишлаб чиқарилган йили')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('color')
                        ->label('Ранги')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('technical_condition')
                        ->label('Техник ҳолати')
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('model')
                        ->label('Модели')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contract')
                        ->label('Шартнома')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('address')
                        ->label('Манзил')
                        ->maxLength(255),
                ]),
                Forms\Components\Textarea::make('additional_info')
                    ->label('Кушимча маълумот')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('additional_info2')
                    ->label('Дополнительная информация 2')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('additional_info3')
                    ->label('Дополнительная информация 3')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('mediaAttachments')
                    ->label('Медиа файллар')
                    ->multiple()
                    ->formatStateUsing(function($record) {
                        if (!$record) {
                            return [];
                        }
                        /** @var Transport $record */
                        $value = $record->mediaAttachments->map(fn($attachment) => $attachment->file_path);
                        return $value->toArray();
                    })
                    ->storeFiles(false)
                    ->image()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('docAttachments')
                    ->label('Документлар')
                    ->multiple()
                    ->formatStateUsing(function($record) {
                        if (!$record) {
                            return [];
                        }
                        /** @var Transport $record */
                        $value = $record->docAttachments->map(fn($attachment) => $attachment->file_path);
                        return $value->toArray();
                    })
                    ->storeFiles(false)
                    ->image()
                    ->columnSpanFull(),
                Forms\Components\Select::make('categories')
                    ->label('Категориялар')
                    ->multiple()
                    ->preload()
                    ->relationship('categories', 'title')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner')
                    ->searchable(),
                Tables\Columns\TextColumn::make('car_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year_of_issue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('technical_condition')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
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
            // add relation for media and document attachments to model Attachment with morpth relationship
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransports::route('/'),
            'create' => Pages\CreateTransport::route('/create'),
            'edit' => Pages\EditTransport::route('/{record}/edit'),
        ];
    }
}
