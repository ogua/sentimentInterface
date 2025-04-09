<?php

namespace App\Filament\Resources\SurveyResource\Widgets;

use App\Models\Survey;
use App\Models\Response;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SurveyStatistics extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Surveys',Survey::count())
            ->color('success')
            ->descriptionIcon('heroicon-m-chart-bar-square'),

            Stat::make('Total Active Survey', Survey::where('is_active',true)->count())
            ->color('info')
            ->descriptionIcon('heroicon-m-chat-bubble-left-right'),

            Stat::make('Total Responses', Response::count())
            ->color('info')
            ->descriptionIcon('heroicon-m-chat-bubble-left-right')
        ];
    }
}
