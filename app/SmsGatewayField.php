<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsGatewayField extends Model
{
    protected $guarded = ['id'];

    public function smsGateway(){
        return $this->belongsTo(SmsGateway::class);
    }
}
