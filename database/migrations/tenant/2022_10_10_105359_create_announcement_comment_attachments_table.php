<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_comment_attachments', function (Blueprint $table) {
            $prefix = \Illuminate\Support\Facades\DB::getTablePrefix();
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('announcement_comment_id');
            $table->foreign('announcement_comment_id',$prefix.'announcement_comment_attachment_foreign')->references('id')->on('announcement_comments')->onDelete('cascade');
            $table->string('file_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_comment_attachments');
    }
};
