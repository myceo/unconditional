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
        if(!\App\Models\PaymentMethodField::where('key','mode')->where('payment_method_id',1)->exists()){
        \App\Models\PaymentMethodField::create([
            'key'=>'mode',
            'payment_method_id'=>1,
            'type'=>'select',
            'options'=>'live=Live,sandbox=Sandbox'
        ]);
     }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
