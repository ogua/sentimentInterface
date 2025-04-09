<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SentimentAnalysis;

class TrainAnalylists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test predictions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $text = "Very good";
        $response = SentimentAnalysis::analiyseRespose($text);

        logger($response);
    }
}
