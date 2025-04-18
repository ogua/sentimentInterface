<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NlpModel extends Model
{
    /** @use HasFactory<\Database\Factories\NlpModelFactory> */
    use HasFactory, HasUuids;
}
