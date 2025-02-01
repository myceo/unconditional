<?php

namespace App\Livewire\Admin\Course;

use App\Course;
use Livewire\Component;
use Livewire\WithPagination;
use App\User;


class UserList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public Course $course;

    public function render()
    {

        $perPage = 20;
        if(!empty($this->search)){
            $users = $this->course->users()->nonAdmins()->where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                ->paginate($perPage);

        }
        else{
            $users = $this->course->users()->nonAdmins()->latest()->paginate($perPage);
        }

        return view('livewire.admin.course.user-list', [
            'users' => $users
        ]);
    }

    public function removeUser($id){
        $this->course->users()->detach($id);
    }
}
