<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFtToHelp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('help_posts', function (Blueprint $table) {
            $name = $table->getTable();
            $prefix = \Illuminate\Support\Facades\DB::getTablePrefix();
            $name = $prefix.$name;
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE {$name} ADD FULLTEXT full(title,content)");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('help_posts', function (Blueprint $table) {
            //
        });
    }
}
