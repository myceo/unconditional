<?php

namespace App\Http\Controllers\Tenant\Admin\Training;

use App\Course;
use App\Http\Controllers\Tenant\Controller;
use App\Http\Requests;

use App\Lesson;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class LessonsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request,Course $course)
    {

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $lessons = $course->lessons()->where('name', 'like', '%'.$keyword.'%')->paginate($perPage);
        } else {
            $lessons = $course->lessons()->orderBy('sort_order')->orderBy('name')->paginate($perPage);
        }

        return view('admin.lessons.index', compact('lessons','perPage','course','keyword'));
    }


    public function create(Course $course)
    {
        return view('admin.lessons.create',compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request,Course $course)
    {
        $this->validate($request,[
            'name'=>'required',
            'picture'=>'nullable|image'
        ]);

        $requestData = $request->all();
        $requestData['sort_order'] = $this->getNextSortOrder($course);

        $lesson = $course->lessons()->create($requestData);
        //check if image is present
        if($request->files->has('picture')){
            $path = $request->picture->store(COURSE_FILES);
            $file = $path;
            $img = Image::make($file);

            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($file);
            $lesson->picture = $file;
            $lesson->save();

        }


        return redirect()->route('admin.courses.classes.index',['course'=>$course])->with('flash_message', __('site.changes-saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Course $course,Lesson $lesson)
    {

        return view('admin.lessons.show', compact('lesson','course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Course $course,Lesson $lesson)
    {


        return view('admin.lessons.edit', compact('lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Course $course,Lesson $lesson)
    {
        $this->validate($request,[
            'name'=>'required',
            'picture'=>'nullable|image'
        ]);

        $requestData = $request->all();

        $lesson->update($requestData);
        if($request->files->has('picture')){
            @unlink($lesson->picture);
            $path = $request->picture->store(COURSE_FILES);
            $file = $path;
            $img = Image::make($file);

            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($file);
            $lesson->picture = $file;
            $lesson->save();

        }

        return redirect()->route('admin.courses.classes.index',['course'=>$lesson->course_id])->with('flash_message', __('site.changes-saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Course $course,Lesson $lesson)
    {
        //delete image
        @unlink($lesson->picture);
        $lesson->delete();
        return redirect()->route('admin.courses.classes.index',['course'=>$course->id])->with('flash_message', __('site.record-deleted'));

    }

    public function removeImage(Lesson $lesson){
        @unlink($lesson->picture);
        $lesson->picture = null;
        $lesson->save();
        flashMessage(__('site.changes-saved'));
        return back();
    }


    private function getNextSortOrder(Course $course){
        $lastRecord = $course->lessons()->orderBy('sort_order','desc')->first();
        if($lastRecord){
            $sortOrder = $lastRecord->sort_order +1;
        }
        else{
            $sortOrder = 1;
        }
        return $sortOrder;
    }


}
