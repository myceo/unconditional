<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lesson extends Model
{
    protected $fillable = ['course_id','name','description','sort_order','enforce_lecture_order'];
    use HasFactory;

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function lectures(){
        return $this->hasMany(Lecture::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function scopeOrdered($query){
        return $query->orderBy('sort_order');
    }

    public function getPreviousLesson(){
          $sortOrder = $this->sort_order;
          return $this->course->lessons()->where('sort_order','<',$sortOrder)->orderBy('sort_order','desc')->first();
    }

    public function getNextLesson(){
        $sortOrder = $this->sort_order;
        return $this->course->lessons()->where('sort_order','>',$sortOrder)->orderBy('sort_order')->first();
    }

}
