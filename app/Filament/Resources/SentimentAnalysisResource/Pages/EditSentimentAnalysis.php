<?php

namespace App\Filament\Resources\SentimentAnalysisResource\Pages;

use App\Filament\Resources\SentimentAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSentimentAnalysis extends EditRecord
{
    protected static string $resource = SentimentAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
