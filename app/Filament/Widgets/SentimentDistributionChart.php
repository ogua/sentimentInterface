<?php

namespace App\Filament\Widgets;

use App\Models\Response;
use App\Models\SentimentAnalysis;
use Filament\Widgets\ChartWidget;

class SentimentDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Distribution';
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = SentimentAnalysis::select('sentiment_label')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('sentiment_label')
            ->pluck('total', 'sentiment_label')
            ->toArray();

        return [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'Responses',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#22c55e', // positive
                        '#facc15', // neutral
                        '#ef4444', // negative
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
