<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('test_question_id')->constrained()->onDelete('cascade');
            $table->text('option');
            $table->boolean('is_correct')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_options');
    }
};
