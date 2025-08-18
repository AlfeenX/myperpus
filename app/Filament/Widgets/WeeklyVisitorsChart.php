<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\VisitorLog;

class WeeklyVisitorsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Mingguan Pengunjung';

    protected function getData(): array
    {
        $data = Trend::model(VisitorLog::class)
        ->between(
            start : now()->subDays(6),
            end : now()
        )
        -> perDay()
        ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Banyak siswa datang',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
