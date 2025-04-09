<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Response extends Model
{
    /** @use HasFactory<\Database\Factories\ResponseFactory> */
    use HasFactory,HasUuids;

    public function survey() : BelongsTo {
        return $this->belongsTo(Survey::class,"survey_id");
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class,"user_id");
    }

    public function surveyAnswer() : HasMany {
        return $this->hasMany(ResponseAnswer::class,"response_id");
    }
}
