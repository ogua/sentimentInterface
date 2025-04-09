<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, HasUuids;

    protected $casts = [
        'options' => 'array',
    ];
    
    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function responses() {
        return $this->hasMany(Response::class);
    }

    public function answers() {
        return $this->hasMany(ResponseAnswer::class,"question_id");
    }

    public function analysts() : HasOne {
        return $this->hasOne(SentimentAnalysis::class,"response_answer_id");
    }
}
