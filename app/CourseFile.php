<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CourseFile extends Model
{
    protected $fillable = ['course_id','path','name'];
    use HasFactory;

    public function course(){
        return $this->belongsTo(Course::class);
    }

}
