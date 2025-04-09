<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyFactory> */
    use HasFactory, HasUuids;

    public function questions() {
        return $this->hasMany(Question::class);
    }
    
    public function responses() {
        return $this->hasMany(Response::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
