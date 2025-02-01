<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','test_id','score'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function test(){
        return $this->belongsTo(Test::class);
    }

    public function userTestOptions(){
        return $this->hasMany(UserTestOption::class);
    }
}
