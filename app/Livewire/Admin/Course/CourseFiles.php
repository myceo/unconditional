<?php

namespace App\Livewire\Admin\Course;

use App\Course;
use App\CourseFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CourseFiles extends Component
{
    public $course;
    public bool $showDelete=true;

/*    public function mount(){
        $this->showDelete = true;
    }*/

    public function render()
    {
        return view('livewire.admin.course.course-files');
    }

    public function delete(CourseFile $file){
        Storage::delete($file->path);
        $file->delete();
        $this->course = Course::find($this->course->id);
    }

    public function download(CourseFile $file){
      return  Storage::download($file->path,$file->name);
    }

}
