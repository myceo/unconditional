<?php

use App\Models\Setting;
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

        $options = [
            'general_site_name' => 1,
            'general_homepage_title' => 2,
            'general_homepage_meta_desc' => 3,
            'general_admin_email' => 4,
            'general_address' => 5,
            'general_tel' => 6,
            'general_contact_email' => 7,
            'general_enable_registration' => 8,
            'general_header_scripts' => 10,
            'general_footer_scripts' => 11,
            'general_disqus_shortcode'=>12
        ];

        foreach ($options as $key => $value) {
            Setting::where('settings.key', trim($key))->update(['sort_order' => $value]);
        }


            Setting::insert(
            [
                ['key'=>'general_captcha','type'=>'radio','options'=>'1=Yes,0=No','value'=>0,'sort_order'=>9]
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('settings.key','general_captcha')->delete();
    }
};
