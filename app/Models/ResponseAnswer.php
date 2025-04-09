<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResponseAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\ResponseAnswerFactory> */
    use HasFactory,HasUuids;

    public function surveyQuestion() : BelongsTo {
        return $this->belongsTo(Question::class,"question_id");
    }

    public function surveyResponse() : BelongsTo {
        return $this->belongsTo(Response::class,"response_id");
    }
}
