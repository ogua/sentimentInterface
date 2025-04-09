<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ResponseResource;

class ListResponses extends ListRecords
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
