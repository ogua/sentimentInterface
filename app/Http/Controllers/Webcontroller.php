<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class Webcontroller extends Controller
{
    public function surveyList($record){

        $survey = Survey::with('questions')
        ->where('id',$record)->first();



        return view('survey.survey-questions',[
            'record' => $record,
            'survey' => $survey,
        ]);
        
    }
}
