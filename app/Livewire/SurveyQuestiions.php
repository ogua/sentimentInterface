<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\Survey;
use Livewire\Component;
use App\Models\Response;
use Filament\Forms\Form;
use App\Models\ResponseAnswer;
use App\Events\SurveySubmitted;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Event;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class SurveyQuestiions extends Component
{

    public ?array $data = [];

    public $record;

    public $survey;

    public $responses = [];
    public $response;
    public $answers;

    public function mount()
    {
        //check id user is authenticated
        if (!auth()->user()) {
            return redirect()->to('/login');
        }

        //update response table
        $response = Response::where('user_id', auth()->user()->id)
        ->where('survey_id', $this->record)
        ->first();

        if ($response) {

            $this->response = $response;

        }else {

            $newResponse = new Response([
                'user_id' => auth()->user()->id,
                'survey_id' => $this->record,
                //'submitted_at' => now(),
                'location' => request()->ip(),
                'device_info' => request()->header('User-Agent'),
            ]);

            $newResponse->save();

            $this->response = $newResponse;
        }
        
        $this->survey = Survey::with('questions')
        ->where('id',$this->record)->first();

        // Load existing answers
        $this->loadAnswers();
    }

    public function loadAnswers()
    {
        $surveyAnswers = ResponseAnswer::where('response_id', $this->response->id)
        ->get();

        // Loop through survey answers and assign to responses array
        foreach ($surveyAnswers as $surveyAnswer) {

            $surveyQuestion = $surveyAnswer->surveyQuestion;

            $options = $surveyQuestion->options;
            $queType = $surveyQuestion?->question_type;
            $answer = $surveyAnswer->answer_text;

            if ($queType == "multiple_choice") {

                // Convert the options string into an array
                $optionsArray = array_map('trim', explode(',', $options));

                // Convert the answer string into an array
                $answerArray = array_map('trim', explode(',', $answer));

                // Initialize an empty array to hold the results
                $results = [];

                // Loop through the options array and check if the option exists in the answer
                foreach ($optionsArray as $index => $option) {
                    if (in_array($option, $answerArray)) {
                        $results[$index] = true;
                    } else {
                        $results[$index] = false;
                    }
                }

            }else{
                $results = $answer;
            }

            $this->responses[$surveyAnswer->question_id] = $results;
        }
    }

    public function create()
    {
        
        foreach ($this->responses as $index => $response) {

           // logger($response);
            
            $question = $this->survey->questions
            ->where('id', $index)
            ->first();

            if (in_array($question?->question_type, ['multiple_choice'])) {

                $options = $question?->options;

                $values = explode(',',$options);

                $results = [];

                foreach ($response as $index => $flag) {
                    if ($flag && isset($values[$index])) {
                        $results[] = trim($values[$index]);
                    }
                }

                $data = implode(',', $results);
            }else {
                $data = $response;
            }


            // Do your saving logic here
            $insertData = [
                'response_id' => $this->response->id,
                'question_id' => $question->id,
                'answer_text' => $data,
            ];
            
            $responseSave = Response::where('user_id', auth()->user()->id)
            ->where('survey_id', $this->record)
            ->first();

            //check if data already exits
            $responseAnswer = ResponseAnswer::where('response_id',$this->response->id)
            ->where('question_id',$question->id)->first();

            if($responseAnswer){
                $responseAnswer->answer_text = $data;
                $responseAnswer->save();
            }else {
                ResponseAnswer::create($insertData);
            }
        
            $responseSave->update([
                'submitted_at' => now(),
            ]);

        }

        // Notification::make()
        //     ->title('Survey Submitted')
        //     ->success()
        //     ->body('Your survey has been submitted successfully.')
        //     ->send();

        Event::dispatch(new SurveySubmitted($this->response->id));

        return redirect()->to('/dashboard')
        ->with('success', 'Survey submitted successfully.');

    }

    public function render(): View
    {
        return view('livewire.survey-questiions');
    }
}