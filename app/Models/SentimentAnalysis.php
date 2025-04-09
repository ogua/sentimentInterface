<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SentimentAnalysis extends Model
{
    /** @use HasFactory<\Database\Factories\SentimentAnalysisFactory> */
    use HasFactory, HasUuids;

    public function responseAnswer() : BelongsTo {
        return $this->belongsTo(ResponseAnswer::class,"response_answer_id");
    }
}
