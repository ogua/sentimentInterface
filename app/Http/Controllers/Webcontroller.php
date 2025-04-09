<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Models\SentimentAnalysis;
use Illuminate\Support\Facades\App;

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

    public function report($report_type,$start_date,$end_date)
    {
        $report = SentimentAnalysis::all();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
    }



}
