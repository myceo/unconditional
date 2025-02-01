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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 191)->nullable(false);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('picture')->nullable();
            $table->text('introduction')->nullable();
            $table->string('effort')->nullable();
            $table->string('length')->nullable();
            $table->boolean('enabled')->default(false);
            $table->boolean('public')->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('closes_on')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('payment_required')->default(false);
            $table->double('fee')->nullable();
            $table->boolean('enforce_capacity')->default(false);
            $table->boolean('enforce_order')->default(false);
            $table->text('certificate_html')->nullable();
            $table->string('certificate_image')->nullable();
            $table->boolean('certificate_enabled')->default(false);
            $table->string('certificate_orientation')->default('l');
            $table->boolean('pinned')->default(false);
            $table->fulltext(['name', 'description', 'short_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
