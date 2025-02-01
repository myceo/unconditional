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
        Schema::create('lecture_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('lecture_id');
            $table->string('title', 191)->nullable(false);
            $table->text('content')->nullable();
            $table->string('type', 191)->nullable(false);
            $table->integer('sort_order')->default(0);
            $table->foreign('lecture_id')->references('id')->on('lectures')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_pages');
    }
};
