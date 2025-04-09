<?php

namespace App\Listeners;

use Illuminate\Log\Logger;
use App\Models\ResponseAnswer;
use App\Events\SurveySubmitted;
use App\Services\SentimentAnalysis;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\SentimentAnalysis as ModelsSentimentAnalysis;

class SendSurveyNotification
{
    /**
    * Create the event listener.
    */
    public function __construct()
    {
        //
    }
    
    /**
    * Handle the event.
    */
    public function handle(SurveySubmitted $event): void
    {
        $responseid = $event->response;
        
        $answers = ResponseAnswer::where('response_id',$responseid)
        ->get();
        
        foreach ($answers as $answer) {
            $text = $answer->answer_text;

            logger($text);

            $response = SentimentAnalysis::analiyseRespose($text);

            logger($response);
            
            $sentimentLabels = ['positive', 'positive', 'negative', 'negative', 'neutral'];
            
            $sentimentLabel = $sentimentLabels[$response] ?? 'neutral'; // fallback to 'neutral' if not enough labels
            
            $polarityScore = match ($sentimentLabel) {
                'positive' => rand(60, 100) / 100,
                'negative' => rand(-100, -60) / 100,
                'neutral'  => 0.0,
                default    => null,
            };
            
            $confidenceScore = match ($sentimentLabel) {
                'positive', 'negative' => rand(75, 95) / 100,
                'neutral' => rand(50, 70) / 100,
                default => null,
            };
            
            $emotions = match ($sentimentLabel) {
                'positive' => ['joy' => 0.8, 'trust' => 0.6],
                'negative' => ['anger' => 0.7, 'disgust' => 0.5],
                'neutral'  => ['calm' => 1.0],
                default    => [],
            };
            
            $aspectTerms = []; // Can fill this later with real NLP
            
            $data = [
                'response_answer_id' => $answer->id,
                'polarity_score' => $polarityScore,
                'sentiment_label' => $response,
                'emotions' => json_encode($emotions),
                'aspect_terms' => null,
                'nlp_model_id' => 1,
                'confidence_score' => $confidenceScore,
                'analyzed_at' => now()
            ];

            $check =  ModelsSentimentAnalysis::where('response_answer_id',$answer->id)
            ->first();

            if($check){
                ModelsSentimentAnalysis::where('response_answer_id',$answer->id)
                ->update($data);
            }else {
                ModelsSentimentAnalysis::create($data);
            }
        }
    }
}
