<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivacyPolicy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = \App\Setting::where('key','general_privacy_policy')->first();

        if(!$setting){
            \App\Setting::insert([
                'key'=>'general_privacy_policy',
                'type'=>'textarea',
                'class'=>'form-control summernote6',
                'sort_order'=>'11'
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
