<?php

namespace App\Livewire;

use Filament\Tables;
use App\Models\Survey;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class SurveyDisplay extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Survey::query())
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->searchable(),

                Tables\Columns\TextColumn::make('description'),

                Tables\Columns\IconColumn::make('is_active')
                ->boolean(),
            ])
    
            ->actions([
                Tables\Actions\Action::make('start')
                    ->label('Start Survey')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->url(fn (Survey $record): string => route('survey.questions.record',['record' => $record->id])),
            ])->filters([
                //
            ]);
    }

    public function render(): View
    {
        return view('livewire.survey-display');
    }
}
