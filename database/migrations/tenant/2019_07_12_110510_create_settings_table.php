<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('key');
            $table->text('label')->nullable();
            $table->text('placeholder')->nullable();;
            $table->text('value')->nullable();;
            $table->boolean('serialized')->default(0);
            $table->string('type');
            $table->text('options')->nullable();
            $table->string('class')->nullable();

        });

        //populate table
        \App\Setting::insert(
            [
                ['key'=>'general_site_name','type'=>'text','options'=>''],
                ['key'=>'general_homepage_title','type'=>'text','options'=>''],
                ['key'=>'general_homepage_meta_desc','type'=>'textarea','options'=>''],
                ['key'=>'general_admin_email','type'=>'text','options'=>''],
                ['key'=>'general_address','type'=>'textarea','options'=>''],
                ['key'=>'general_tel','type'=>'text','options'=>''],
                ['key'=>'general_contact_email','type'=>'text','options'=>''],
                ['key'=>'general_enable_registration','type'=>'radio','options'=>'1=Yes,0=No'],
                ['key'=>'general_header_scripts','type'=>'textarea','options'=>''],
                ['key'=>'general_footer_scripts','type'=>'textarea','options'=>''],
                ['key'=>'image_logo','type'=>'image','options'=>''],
                ['key'=>'image_icon','type'=>'image','options'=>''],
                ['key'=>'mail_protocol','type'=>'select','options'=>'mail=Mail,smtp=SMTP'],
                ['key'=>'mail_smtp_host','type'=>'text','options'=>''],
                ['key'=>'mail_smtp_username','type'=>'text','options'=>''],
                ['key'=>'mail_smtp_password','type'=>'text','options'=>''],
                ['key'=>'mail_smtp_port','type'=>'text','options'=>''],
                ['key'=>'mail_smtp_timeout','type'=>'text','options'=>''],
            ]
        );

        $role = new \App\Role();
        $role->id =1;
        $role->role = 'Admin';
        $role->save();

        $role = new \App\Role();
        $role->id =2;
        $role->role = 'Member';
        $role->save();

        \App\User::create([
            'name'=>'Admin',
            'email'=>'admin@email.com',
            'password'=>bcrypt('password'),
            'role_id'=>1,
            'telephone'=>'',
            'gender'=>'m'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
