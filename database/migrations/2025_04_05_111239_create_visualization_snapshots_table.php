<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visualization_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('survey_id');
            $table->uuid('created_by');
            $table->enum('snapshot_type', ['overall_sentiment', 'trend_analysis', 'emotion_distribution']);
            $table->json('snapshot_data');
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visualization_snapshots');
    }
};
