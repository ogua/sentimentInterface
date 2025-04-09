<?php

namespace App\Filament\Resources\SentimentAnalysisResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SentimentAnalysisResource;
use App\Filament\Resources\SentimentAnalysisResource\Widgets\SentimentGraph;

class ListSentimentAnalyses extends ListRecords
{
    protected static string $resource = SentimentAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SentimentGraph::class
        ];
    }
}
