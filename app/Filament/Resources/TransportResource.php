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
                        ->label(Transport::label('name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('owner')
                        ->label(Transport::label('owner'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('car_number')
                        ->label(Transport::label('car_number'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('year_of_issue')
                        ->label(Transport::label('year_of_issue'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('color')
                        ->label(Transport::label('color'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('technical_condition')
                        ->label(Transport::label('technical_condition'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('model')
                        ->label(Transport::label('model'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contract')
                        ->label(Transport::label('contract'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('address')
                        ->label(Transport::label('address'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('body_number')
                        ->label(Transport::label('body_number'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('curb_weight')
                        ->label(Transport::label('curb_weight'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('unladen_weight')
                        ->label(Transport::label('unladen_weight'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('engine_number')
                        ->label(Transport::label('engine_number'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('engine_power')
                        ->label(Transport::label('engine_power'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fuel_type')
                        ->label(Transport::label('fuel_type'))
                        ->maxLength(255),
                ]),
                Forms\Components\Grid::make()->schema([
                    Forms\Components\TextInput::make('seats_amount')
                        ->label(Transport::label('seats_amount'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('standings_amount')
                        ->label(Transport::label('standings_amount'))
                        ->maxLength(255),
                ]),
                Forms\Components\Textarea::make('additional_info')
                    ->label(Transport::label('additional_info'))
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('additional_info2')
                    ->label(Transport::label('additional_info2'))
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('additional_info3')
                    ->label(Transport::label('additional_info3'))
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('mediaAttachments')
                    ->label(Transport::label('mediaAttachments'))
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
                    ->label(Transport::label('docAttachments'))
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
                    ->columnSpanFull(),
                Forms\Components\Select::make('categories')
                    ->label('Категориялар')
                    ->native(false)
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
                Tables\Columns\ViewColumn::make('mediaAttachments')
                    ->view('tables.columns.multi-file-column', [
                        'relation' => 'mediaAttachments',
                    ])
                    ->label(Transport::label('mediaAttachments')),
                Tables\Columns\TextColumn::make('name')
                    ->label(Transport::label('name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner')
                    ->label(Transport::label('owner'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('car_number')
                    ->label(Transport::label('car_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('year_of_issue')
                    ->label(Transport::label('year_of_issue'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('color')
                    ->label(Transport::label('color'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('technical_condition')
                    ->label(Transport::label('technical_condition'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract')
                    ->label(Transport::label('contract'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(Transport::label('address'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->label(Transport::label('model'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('body_number')
                    ->label(Transport::label('body_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('curb_weight')
                    ->label(Transport::label('curb_weight'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('unladen_weight')
                    ->label(Transport::label('unladen_weight'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('engine_number')
                    ->label(Transport::label('engine_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('engine_power')
                    ->label(Transport::label('engine_power'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('fuel_type')
                    ->label(Transport::label('fuel_type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('seats_amount')
                    ->label(Transport::label('seats_amount'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('standings_amount')
                    ->label(Transport::label('standings_amount'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(Transport::label('created_at'))
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
