<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

    protected $fillable = ['event_id','name','starts','ends','description'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot(['tasks']);
    }

    public function rejections(){
        return $this->hasMany(Rejection::class);
    }
}
