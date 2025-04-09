<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use Filament\Actions;
use App\Filament\Resources\SurveyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSurvey extends CreateRecord
{
    protected static string $resource = SurveyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
