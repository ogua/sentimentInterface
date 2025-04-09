<?php

namespace App\Filament\Resources\SentimentAnalysisResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SentimentAnalysisResource;

class ListSentimentAnalyses extends ListRecords
{
    protected static string $resource = SentimentAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
