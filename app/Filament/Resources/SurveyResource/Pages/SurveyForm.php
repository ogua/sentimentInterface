<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Models\Survey;
use App\Models\Response;
use App\Models\ResponseAnswer;
use App\Events\SurveySubmitted;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;
use App\Filament\Resources\SurveyResource;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Resources\SurveyResource\Widgets\SurveyWidget;

class SurveyForm extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string $resource = SurveyResource::class;

    protected static string $view = 'filament.resources.survey-resource.pages.survey-form';

    public ?array $formData = [];

    public Survey $survey;
    public Response $response;

    public $record;

    public function mount($record): void
    {
       // abort_unless(Auth::check(), 403);

       $this->record = $record;

        $this->survey = Survey::with('questions')->findOrFail($record);

        //update response table
        $this->response = Response::where('survey_id', $record)
        ->first();

        $this->form->fill($this->loadAnswers());
    }

    protected function getFormSchema(): array
    {
        return $this->survey->questions->map(function ($question): Component {
            $questionId = "q_{$question->id}";
            $label = $question->question_text;
            $required = $question->is_required;

            return match ($question->question_type) {
                'text' => Textarea::make($questionId)
                    ->label($label)
                    ->required($required),

                'rating' => Select::make($questionId)
                    ->label($label)
                    ->required($required)
                    ->searchable()
                    ->options(
                        collect(range(1, $question->rating_scale))->mapWithKeys(fn ($i) => [$i => $i])
                    ),

                'single_choice' => Radio::make($questionId)
                    ->label($label)
                    ->required($required)
                    ->options(
                        collect(explode(',', $question?->options))->mapWithKeys(fn ($opt) => [trim($opt) => trim($opt)])
                    ),

                'multiple_choice' => CheckboxList::make($questionId)
                    ->label($label)
                    ->required($required)
                    ->options(
                        collect(explode(',', $question->options))->mapWithKeys(fn ($opt) => [trim($opt) => trim($opt)])
                    ),

                default => Textarea::make($questionId)->label($label),
            };
        })->toArray();
    }

    protected function loadAnswers(): array
    {
        $answers = [];

        foreach ($this->response?->answers ?? [] as $answer) {
            $key = "q_{$answer->question_id}";

            if ($answer->surveyQuestion->question_type === 'multiple_choice') {
                $answers[$key] = explode(',', $answer->answer_text);
            } else {
                $answers[$key] = $answer->answer_text;
            }
        }

        return $answers;
    }

    public function submit()
    {
        foreach ($this->form->getState() as $key => $response) {
            $questionId = (int) str_replace('q_', '', $key);
            $question = $this->survey->questions->firstWhere('id', $questionId);

            if (!$question) continue;

            $answerText = is_array($response) ? implode(',', $response) : $response;

            ResponseAnswer::updateOrCreate(
                [
                    'response_id' => $this->response->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer_text' => $answerText,
                ]
            );
        }

        $this->response->update([
            'submitted_at' => now(),
        ]);

        event(new SurveySubmitted($this->response->id));

        Notification::make()
            ->title('Survey Submitted')
            ->success()
            ->body('Your survey has been submitted successfully.')
            ->send();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SurveyWidget::make(['record' => $this->survey->id])
        ];
    }
}
