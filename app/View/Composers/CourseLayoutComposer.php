<?php

namespace App\View\Composers;

use App\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class CourseLayoutComposer
{
    public function compose(View $view)
    {
        $course = Route::current()->parameter('course');
        if(is_int($course)){
            $course = Course::findOrFail($course);
        }

        $user = Auth::user();
        $view->with('course', $course);
        $view->with('user',$user);
    }
}
