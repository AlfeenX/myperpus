<?php

namespace App\Filament\Imports;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookImporter extends Importer
{
    protected static ?string $model = Book::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('author')
                ->requiredMapping()
                ->relationship(resolveUsing: function (string $state): Author {
                    return Author::firstOrCreate([
                        'name' => $state
                    ]);
                }),
            ImportColumn::make('publisher')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('year')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer']),
            ImportColumn::make('stock')
                ->requiredMapping()
                ->integer()
                ->rules(['required', 'integer']),
            ImportColumn::make('category')
                ->requiredMapping()
                ->relationship(resolveUsing: function (string $state): Category {
                    return Category::firstOrCreate([
                        'name' => $state,
                        'slug' => $state
                    ]);
                })
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Book
    {
        $author = Author::firstOrCreate(['name' => $this->data['author']]);

        $category = Category::firstOrCreate([
            'name' => $this->data['category'],
            'slug' => Str::slug($this->data['category'])
        ]);

        $book = Book::where('title', $this->data['title'])->first();
        $existingStock = $book?->stock ?? 0;

        $updatedStock = Book::updateOrCreate(
            ['title' => $this->data['title']],
            [
                'author_id'   => $author->id,
                'publisher'   => $this->data['publisher'],
                'year'        => (int) $this->data['year'],
                'stock'       => $existingStock + (int) $this->data['stock'],
                'category_id' => $category->id
            ]
        );

        Log::info('Stok updated', [
            'title' => $updatedStock->title,
            'stock' => $updatedStock->stock
        ]);

        return $updatedStock;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your book import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
