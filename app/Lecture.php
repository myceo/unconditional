<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lecture extends Model
{

    protected $fillable = ['lesson_id','title','sort_order'];
    use HasFactory;

    public function lecturePages(){
        return $this->hasMany(LecturePage::class);
    }

    public function lectureFiles(){
        return $this->hasMany(LectureFile::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    public function scopeOrdered($query){
        return $query->orderBy('sort_order');
    }

    public function getPrevious(){
        $sortOrder = $this->sort_order;
        return $this->lesson->lectures()->where('sort_order','<',$sortOrder)->orderBy('sort_order','desc')->first();
    }


    public function getNext(){
        $sortOrder = $this->sort_order;
        return $this->lesson->lectures()->where('sort_order','>',$sortOrder)->orderBy('sort_order')->first();
    }



}
