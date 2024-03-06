<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Category;
use Filament\Tables\Table;
use App\Enums\CategoryType;
use Filament\Resources\Resource;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $pluralLabel = 'Категориялар';
    protected static ?string $navigationIcon = 'heroicon-m-briefcase';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->options(Category::pluck('title', 'id')->toArray())
                    ->nullable(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(CategoryType::labels())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    // casts to CategoryType
                    ->getStateUsing(function(Category $record) {
                        return $record->type->getLabel();
                    })
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent_id')
                    ->numeric()
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
