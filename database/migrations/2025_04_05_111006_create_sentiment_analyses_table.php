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
        Schema::create('sentiment_analyses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('response_answer_id');
            $table->float('polarity_score');
            $table->enum('sentiment_label', ['positive', 'neutral', 'negative', 'mixed']);
            $table->json('emotions')->nullable();
            $table->json('aspect_terms')->nullable();
            $table->uuid('nlp_model_id');
            $table->float('confidence_score');
            $table->timestamp('analyzed_at')->nullable();
            $table->timestamps();

            $table->foreign('response_answer_id')->references('id')->on('response_answers')->onDelete('cascade');
            //$table->foreign('nlp_model_id')->references('id')->on('nlp_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentiment_analyses');
    }
};
