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
        Schema::create('nlp_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('language')->default('en');
            $table->string('version');
            $table->enum('source', ['local', 'api', 'python_service']);
            $table->float('accuracy_score')->nullable();
            $table->boolean('active')->default(false);
            $table->uuid('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nlp_models');
    }
};
