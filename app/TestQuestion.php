<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['test_id','question','sort_order'];

    public function test(){
        return $this->belongsTo(Test::class);
    }

    public function testOptions(){
        return $this->hasMany(TestOption::class);
    }

    public function setQuestion($value){
        $this->attributes['question'] = saveInlineImages($value);
    }

    public function scopeOrdered($builder){
        return $builder->orderBy('sort_order','asc');
    }
}
