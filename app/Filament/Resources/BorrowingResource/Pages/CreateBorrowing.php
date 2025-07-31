<?php

namespace App\Filament\Resources\BorrowingResource\Pages;

use App\Filament\Resources\BorrowingResource;
use App\Models\Book;
use Exception;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateBorrowing extends CreateRecord
{
    protected static string $resource = BorrowingResource::class;

    protected function beforeCreate(): void
    {
        $book = Book::find($this->data['book_id']);
        if ($book->stock === 0) {
            Notification::make()
            ->title('Gagal menambahkan data!')
            ->body('Stok buku habis')
            ->danger()
            ->send();
            throw ValidationException::withMessages([]);
        }

        $book->decrement('stock');
    }
}
