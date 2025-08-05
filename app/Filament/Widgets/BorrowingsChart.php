<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BorrowingsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Peminjaman';

    protected static string $color = 'primary';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Peminjaman per bulan',
                    'data' => [2, 21, 32, 45, 74, 65, ],
                ],
            ],
            'labels' => ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug',],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
