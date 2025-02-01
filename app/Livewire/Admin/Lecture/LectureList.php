<?php

namespace App\Livewire\Admin\Lecture;

use App\Lecture;
use App\Lesson;
use Livewire\Component;

class LectureList extends Component
{

    public $lessonId;

    public function render()
    {
        $lesson = Lesson::find($this->lessonId);
        $lectures = $lesson->lectures()->orderBy('sort_order')->get();
        return view('livewire.admin.lecture.lecture-list',compact('lectures','lesson'));
    }

    public function updateTaskOrder($ids){
        foreach($ids as $value){
            $lesson = Lecture::find($value['value']);
            if($lesson){
                $lesson->sort_order = $value['order'];
                $lesson->save();
            }
        }
    }

}
