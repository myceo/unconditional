<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','comment','flagable_id','flagable_type'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function flagable(){
        return $this->morphTo();
    }



}
