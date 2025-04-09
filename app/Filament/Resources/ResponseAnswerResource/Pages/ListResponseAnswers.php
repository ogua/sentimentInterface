<?php

namespace App\Filament\Resources\ResponseAnswerResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ResponseAnswerResource;

class ListResponseAnswers extends ListRecords
{
    protected static string $resource = ResponseAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
