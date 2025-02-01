<?php

namespace App\Http\Middleware;

use App\Course;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnrolledCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $courseId = $request->route('course');
        if(!$user->courses()->find($courseId)){
            flashMessage(__('site.not-enrolled'));
            return redirect()->route('candidate.my-courses');
        }


        $course = Course::find($courseId)->first();

        //check if course is enabled

        if(empty($course->enabled)){
            flashMessage(__('site.course-disabled'));
            return redirect()->route('candidate.my-courses');
        }

        //check if course has started
        if(!empty($course->start_date)){
            $start = Carbon::parse($course->start_date);
            if($start > now()){
                flashMessage(__('site.course-not-started',['date'=>dateString($course->start_date)]));
                return redirect()->route('candidate.my-courses');
            }
        }

        if(!empty($course->end_date)){
            $end = Carbon::parse($course->end_date);
            if($end < now()){
                flashMessage(__('site.course-ended',['date'=>dateString($course->end_date)]));
                return redirect()->route('candidate.my-courses');
            }
        }

        return $next($request);

    }
}
