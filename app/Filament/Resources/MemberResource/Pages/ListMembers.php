<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Imports\MemberImporter;
use App\Filament\Resources\MemberResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
            ->label('Impor Anggota')
            ->importer(MemberImporter::class)
        ];
    }
}
