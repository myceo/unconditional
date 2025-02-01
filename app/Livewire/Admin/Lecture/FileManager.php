<?php

namespace App\Livewire\Admin\Lecture;

use App\Lecture;
use App\LectureFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class FileManager extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $file;
    public $files = [];
    public $lectureID;


    public function render()
    {
        $lectureFiles = Lecture::find($this->lectureID)->lectureFiles()->paginate(30);
        return view('livewire.admin.lecture.file-manager',['lectureFiles'=>$lectureFiles]);
    }


    public function upload()
    {

        $this->validate([
            'file' => 'required|file|max:'.env('MAX_UPLOAD_SIZE','10240'), // Max file size: 10MB (you can adjust this)
        ]);

        $path = $this->file->store(COURSE_FILES,PUBLIC_UPLOADS); // Store the file in the "files" directory
        $lecture = Lecture::find($this->lectureID);
        $lecture->lectureFiles()->create([
            'path'=>$path,
            'name'=>$this->file->getClientOriginalName()
        ]);


        $this->reset('file'); // Clear the file input field
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>__('site.file-uploaded')
        ]);
    }

    public function delete($index)
    {
        $lectureFile = LectureFile::find($index);
        Storage::delete($lectureFile->path); // Delete the file from storage

        if($lectureFile){
            $lectureFile->delete();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>__('site.record-deleted')
            ]);
        }
    }

}
