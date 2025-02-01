<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LecturePage extends Model
{
    protected $fillable = ['title','content','type','sort_order','lecture_id'];
    use HasFactory;

    public function lecture(){
        return $this->belongsTo(Lecture::class);
    }

    public function scopeOrdered($query){
        return $query->orderBy('sort_order');
    }

    public function getPrevious(){
        $sortOrder = $this->sort_order;
        return $this->lecture->lecturePages()->where('sort_order','<',$sortOrder)->orderBy('sort_order','desc')->first();
    }

    public function getNext(){
        $sortOrder = $this->sort_order;
        return $this->lecture->lecturePages()->where('sort_order','>',$sortOrder)->orderBy('sort_order')->first();
    }
}
