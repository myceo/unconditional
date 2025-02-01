<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Setting::insert(
            [

                ['key'=>'social_callback_urls','type'=>'include','options'=>'admin.settings.includes.social-callbacks','value'=>'0'],
            ]
        );

        \App\Setting::insert(
            [
                ['key'=>'social_enable_facebook','type'=>'radio','options'=>'0=No,1=Yes'],
            ]);
        \App\Setting::insert(
            [
                ['key'=>'social_facebook_app_secret','type'=>'text'],
                ['key'=>'social_facebook_app_id','type'=>'text'],
            ]);

        \App\Setting::insert(
            [
                ['key'=>'social_enable_google','type'=>'radio','options'=>'0=No,1=Yes'],
            ]);
        \App\Setting::insert(
            [
                ['key'=>'social_google_app_secret','type'=>'text'],
                ['key'=>'social_google_app_id','type'=>'text'],
            ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
