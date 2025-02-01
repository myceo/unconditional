<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name','department_id'];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
