<?php

namespace App\Filament\Resources\SentimentAnalysisResource\Widgets;

use App\Models\SentimentAnalysis;
use Filament\Widgets\ChartWidget;

class SentimentGraph extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Analysis';

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
