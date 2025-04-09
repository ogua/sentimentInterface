<?php

namespace App\Filament\Resources\SurveyResource\Widgets;

use App\Models\SentimentAnalysis;
use Filament\Widgets\ChartWidget;

class SurveyWidget extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Analysis';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    public $record;

    protected function getData(): array
    {        
        //response has survey_id
        //responseAnwser has response_id
        //sentiment has responseAnswer_id
        
        $data = SentimentAnalysis::whereHas('responseAnswer.surveyResponse', function ($query) {
            $query->where('survey_id', $this->record);
        })->select('sentiment_label')
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
