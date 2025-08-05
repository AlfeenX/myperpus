<?php

namespace App\Filament\Widgets;

use App\Models\Borrowing;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularBookWidgets extends BaseWidget
{
    protected static ?string $heading = 'Buku Paling Populer';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Borrowing::selectRaw('book_id as id, book_id, COUNT(*) as total')
                    ->groupBy('book_id')
                    ->orderByDesc('total')
                    ->with('book')
                    ->limit(5);
            })
            ->columns([
                TextColumn::make('book.title')
                    ->description(fn ($record) => optional($record->book->author)->name)
                    ->label('Judul Buku')
                    ->wrap(),

                TextColumn::make('total')
                    ->label('Jumlah Dipinjam'),
            ]);
    }
}
