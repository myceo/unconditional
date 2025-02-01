<?php

namespace App\Http\Controllers\Tenant\Site;

use App\Course;
use App\Http\Controllers\Tenant\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CoursesController extends Controller
{

    public function courses(Request $request){
        $keyword = $request->get('search');
        $perPage = 24;
        $courses = Course::openCourses()->publicCourses();


        $sort = $request->get('sort', null);
        if (empty($sort)) {
            $sort=null;
        }

        if(!empty($keyword)){
            $courses = $courses->whereFullText(['name','description','short_description'],$keyword);
        }
        elseif(empty($sort)){
            $courses = $courses->orderBy('pinned','desc')->latest();
        }

        if(!empty($request->category)){
            $courses  = $courses->whereHas('courseCategories',function (Builder $query) use($request){
                $query->where('id',$request->category);
            });
        }

        switch ($sort){
            case 'recent':
                $courses = $courses->latest();
                break;
            case 'asc':
                $courses = $courses->orderBy('name','asc');
                break;
            case 'desc':
                $courses = $courses->orderBy('name','desc');
                break;
            case 'priceAsc':
                $courses = $courses->orderBy('fee','asc');
                break;
            case 'priceDesc':
                $courses = $courses->orderBy('fee','desc');
                break;
        }

        $payment = $request->get('payment',null);
        if($payment != null){
            $courses = $courses->where('payment_required',$payment);
        }

        $courses =   $courses->paginate($perPage)->withQueryString();

        return view('site.courses.courses',compact('courses'));
    }

    public function course(Course $course){
        $course = Course::openCourses()->publicCourses()->findOrFail($course->id);
        return view('site.courses.course',compact('course'));
    }

    public function myCourses(){
        $user = Auth::user();
        $courses = $user->courses()->openCourses()->paginate(24);
        $total = $user->courses()->openCourses()->count();
        return view('site.courses.my-courses',compact('courses','total','user'));
    }

    public function remove(Course $course){
        $user = Auth::user();
        $user->courses()->detach($course->id);
        return back();
    }

    public function enroll(Course $course){
        $course = Course::openCourses()->publicCourses()->findOrFail($course->id);

        $user = Auth::user();
        if($user->courses()->find($course->id))
        {
            return redirect()->route('lms.landing',['course'=>$course->id]);
        }

        if(!canEnroll($course)){
            flashMessage(__('site.enrollment-unavailable'));
            return back();
        }

        //enforce capacity
        if($course->enforce_capacity==1 && $course->users()->count() >= $course->capacity){
            flashMessage(__('site.capacity-exceeded'));
            return back();
        }


            $user->courses()->attach($course->id);
            return redirect()->route('lms.landing',['course'=>$course->id]);


    }



}
