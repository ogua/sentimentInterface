<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomAnalysisSettings extends Model
{
    /** @use HasFactory<\Database\Factories\CustomAnalysisSettingsFactory> */
    use HasFactory, HasUuids;
}
