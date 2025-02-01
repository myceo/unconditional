<?php

namespace App\Livewire\Admin\Course;

use App\Course;
use Livewire\Component;

class PinnedCourse extends Component
{
    public Course $course;
    public function render()
    {
        return view('livewire.admin.course.pinned-course');
    }

    public function setPinned($option){
        $this->course->pinned = $option;
        $this->course->save();
    }
}
