<?php

namespace App\Filament\Exports;

use App\Models\Borrowing;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BorrowingExporter extends Exporter
{
    protected static ?string $model = Borrowing::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('member.name')
                ->label('Nama Anggota'),
            ExportColumn::make('book.title')
                ->label('Nama Buku'),
            ExportColumn::make('user.name')
                ->label('Petugas'),
            ExportColumn::make('borrow_date')
                ->label('Tanggal Pinjam'),
            ExportColumn::make('due_date')
                ->label('Tanggal Jatuh Tempo'),
            ExportColumn::make('return_at')
                ->label('Tanggal Dikembalikan'),
            ExportColumn::make('status'),
            ExportColumn::make('created_at')
                ->label('Dibuat Tanggal'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Tanggal'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Proses export data peminjaman selesai dan ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' telah diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
