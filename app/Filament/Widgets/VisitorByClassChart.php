<?php

namespace App\Filament\Widgets;

use App\Models\VisitorLog;
use Filament\Widgets\ChartWidget;

class VisitorByClassChart extends ChartWidget
{
    protected static ?string $heading = 'Persentase Pengunjung per Kelas';

    protected function getData(): array
    {
        $data = VisitorLog::query()
            ->join('members', 'visitor_logs.member_id', '=', 'members.id')
            ->join('classrooms', 'members.classroom_id', '=', 'classrooms.id')
            ->selectRaw('classrooms.name as classroom_name, COUNT(visitor_logs.id) as total')
            ->groupBy('classrooms.name')
            ->get();

        $totalAll = $data->sum('total');
        $labels = $data->map(function ($item) use ($totalAll) {
            $percent = $totalAll > 0 ? round(($item->total / $totalAll) * 100, 1) : 0;
            return $item->classroom_name . "({$percent}%)";
        });

        $counts = $data->map(fn($item) => $item->total);
        return [
            'datasets' => [
                [
                    'label' => 'Pengunjung',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#6366F1',
                        '#F59E0B',
                        '#10B981',
                        '#EF4444',
                        '#3B82F6',
                    ]
                ]
            ],
            'labels' => $labels
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
