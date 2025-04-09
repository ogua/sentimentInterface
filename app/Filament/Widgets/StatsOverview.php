<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\Response;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Surveys',Survey::count())
            ->color('success')
            ->descriptionIcon('heroicon-m-chart-bar-square'),

            Stat::make('Total Responses', Response::count())
            ->color('info')
            ->descriptionIcon('heroicon-m-chat-bubble-left-right'),
        ];
    }
}
