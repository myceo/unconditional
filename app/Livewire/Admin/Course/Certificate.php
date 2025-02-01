<?php

namespace App\Livewire\Admin\Course;

use App\Course;
use Livewire\Component;
use Livewire\WithFileUploads;

class Certificate extends Component
{
    use WithFileUploads;
    public $file;
    public Course $course;
    public $width;
    public $height;

    public function mount(){
        if($this->course->certificate_orientation=='p'){
            $this->width = 595;
            $this->height = 842;
        }
        else{
            $this->width = 842;
            $this->height = 595;
        }
    }


    public function render()
    {
        return view('livewire.admin.course.certificate');
    }

    public function upload()
    {

        $this->validate([
            'file' => 'required|image|max:'.env('MAX_UPLOAD_SIZE','10240'), // Max file size: 10MB (you can adjust this)
        ]);

        $path = $this->file->store(COURSE_FILES,PUBLIC_UPLOADS); // Store the file in the "files" directory
        $this->course->certificate_image = UPLOAD_PATH.'/'.$path;
        $this->course->save();


        $this->reset('file'); // Clear the file input field
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>__('site.file-uploaded')
        ]);
    }

    public function deleteImage()
    {
        $this->course->certificate_image = null;
        $this->course->save();
    }
}
