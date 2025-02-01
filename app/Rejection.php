<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    protected $fillable = ['shift_id','user_id','message'];

    public function shift(){
        return $this->belongsTo(Shift::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
