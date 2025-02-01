<?php

namespace App\Livewire\Admin\Lecture;

use App\Lecture;
use App\LecturePage;
use Illuminate\Http\Request;
use Livewire\Component;

class LecturePages extends Component
{

    public $lectureId;

    public function render()
    {
        $lecture = Lecture::find($this->lectureId);
        $lecturepages = $lecture->lecturePages()->ordered()->get();
        return view('livewire.admin.lecture.lecture-pages',compact('lecture','lecturepages'));
    }

    public function updateTaskOrder($ids){
        foreach($ids as $value){
            $lecturePage = LecturePage::find($value['value']);
            if($lecturePage){
                $lecturePage->sort_order = $value['order'];
                $lecturePage->save();
            }
        }
    }

    public function delete($id){
        $item = LecturePage::find($id);
        if($item->type=='i'){
            @unlink($item->content);
        }
        $item->delete();
    }


}
