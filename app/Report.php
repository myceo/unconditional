<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['event_id','user_id','content'];

    public function event(){
        return $this->belongsTo(Event::class);
    }


}
