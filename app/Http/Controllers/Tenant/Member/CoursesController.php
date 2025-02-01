<?php

namespace App\Http\Controllers\Tenant\Member;

use App\Course;
use App\Http\Controllers\Tenant\Controller;
use App\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CoursesController extends Controller
{

    public function index(Request $request){
        $keyword = $request->get('search');
        $perPage = 24;
      //  $courses = Course::openCourses()->publicCourses();
        $courses = Course::where(function ($query){
            $query->openCourses()->publicCourses();
            $query->orWhere(function ($query){
                $query->openCourses();
                $query->whereHas('departments', function (Builder $query){
                    $query->where('id',getDepartment()->id);
                });
            });
        });

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

        return view('member.courses.index',compact('courses'));

    }

    public function details(Course $course){
        $course = Course::where(function ($query){
            $query->openCourses()->publicCourses();
            $query->orWhere(function ($query){
                $query->openCourses();
                $query->whereHas('departments', function (Builder $query){
                    $query->where('id',getDepartment()->id);
                });
            });
        })->findOrFail($course->id);


        return view('member.courses.course',compact('course'));
    }

    public function enroll(Course $course){

        $course = Course::where(function ($query){
            $query->openCourses()->publicCourses();
            $query->orWhere(function ($query){
                $query->openCourses();
                $query->whereHas('departments', function (Builder $query){
                    $query->where('id',getDepartment()->id);
                });
            });
        })->findOrFail($course->id);

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
