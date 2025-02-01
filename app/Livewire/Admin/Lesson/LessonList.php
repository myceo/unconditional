<?php

namespace App\Livewire\Admin\Lesson;

use App\Course;
use App\Lesson;
use Livewire\Component;
use Livewire\WithPagination;

class LessonList extends Component
{
    use WithPagination;

    public $courseId;
    public $keyword;

    public function render()
    {
        $course = Course::find($this->courseId);

        $perPage = 250;
        $keyword = $this->keyword;
        if (!empty($keyword)) {
            $lessons = $course->lessons()->where('name', 'like', '%'.$keyword.'%')->paginate($perPage);
        } else {
            $lessons = $course->lessons()->orderBy('sort_order')->orderBy('name')->paginate($perPage);
        }
        return view('livewire.admin.lesson.lesson-list',compact('lessons','course','perPage'));
    }

    public function updateTaskOrder($ids){
        foreach($ids as $value){
            $lesson = Lesson::find($value['value']);
            if($lesson){
                $lesson->sort_order = $value['order'];
                $lesson->save();
            }
        }
    }
}
