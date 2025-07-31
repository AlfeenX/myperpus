<?php

namespace App\Filament\Resources\BorrowingResource\Pages;

use App\Filament\Exports\BorrowingExporter;
use App\Filament\Resources\BorrowingResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListBorrowings extends ListRecords
{
    protected static string $resource = BorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(BorrowingExporter::class)
                ->formats([
                    ExportFormat::Xlsx
                ])
                ->label('Ekspor Peminjaman'),
        ];
    }
}
