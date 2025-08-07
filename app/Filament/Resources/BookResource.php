<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Library Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('title')
                        ->label('Judul Buku')
                        ->translateLabel()
                        ->required()
                        ->maxLength(255),
                    Select::make('author_id')
                        ->label('Penulis')
                        ->relationship('author', 'name')
                        ->required(),
                    TextInput::make('publisher')
                        ->label('Penerbit')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('year')
                        ->label('Tahun')
                        ->required()
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue(date('Y')),
                    TextInput::make('stock')
                        ->label('Stok')
                        ->numeric(),
                    Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->required()
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('publisher')
                    ->label('Penerbit')->sortable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name')

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();

        if ($locale == 'id') {
            return "Buku";
        }
        return "Books";
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $existData = Book::where('title', $data['title'])
            ->where('author_id', $data['author_id'])
            ->first();

        if ($existData) {
            $existData->increment('stock', $data['stock']);

            Notification::make()
                ->title('Stok berhasil ditambahkan!')
                ->success()
                ->send();

            return [];
        }

        return $data;
    }
}
