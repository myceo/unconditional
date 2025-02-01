<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestOption extends Model
{
    use HasFactory;
    protected $fillable = ['test_question_id','option','is_correct'];

    public function testQuestion(){
        return $this->belongsTo(TestQuestion::class);
    }

    public function userTestOptions(){
        return $this->hasMany(UserTestOption::class);
    }
}
