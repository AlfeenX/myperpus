<?php

namespace App\Filament\Resources\BookResource\Widgets;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Buku', Book::count())
                ->description('Tersedia')
                ->descriptionIcon('heroicon-m-book-open', IconPosition::Before)
                ->chart([5,10,20,15,30])
                ->color('success')
                ->url('admin/books'),
            Stat::make('Anggota', Member::count())
                ->description('Terdaftar')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('info')
                ->chart([10,15,35,50])
                ->url('admin/members'),
            Stat::make('Peminjaman Buku', Borrowing::count())
                ->description('Telah dilakukan')
                ->descriptionIcon('heroicon-m-shopping-bag', IconPosition::Before)
                ->color('warning')
                ->chart([4,7,9,10,20])
                ->url('admin/borrowings'),
        ];
    }
}
