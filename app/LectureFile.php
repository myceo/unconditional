<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LectureFile extends Model
{
    use HasFactory;
    protected $fillable = ['lecture_id','path','name'];

    public function lecture(){
        return $this->belongsTo(Lecture::class);
    }
}
