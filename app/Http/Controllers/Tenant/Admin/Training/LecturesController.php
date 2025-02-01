<?php

namespace App\Http\Controllers\Tenant\Admin\Training;

use App\Http\Controllers\Tenant\Controller;
use App\Http\Requests;

use App\Lecture;
use App\Lesson;
use Illuminate\Http\Request;

class LecturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Lesson $lesson)
    {
        $lectures = $lesson->lectures()->orderBy('sort_order')->get();
        return view('admin.lectures.index', compact('lectures','lesson'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Lesson $lesson)
    {
        return view('admin.lectures.create',compact('lesson'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request,Lesson $lesson)
    {
        $this->validate($request,['title'=>'required']);
        $requestData = $request->all();
        $requestData['sort_order'] = $this->getNextSortOrder($lesson);

        $lesson->lectures()->create($requestData);

        return redirect()->route('admin.classes.lectures.index',['lesson'=>$lesson->id])->with('flash_message', __('site.changes-saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $lecture = Lecture::findOrFail($id);

        return view('admin.lectures.show', compact('lecture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Lesson $lesson,Lecture $lecture)
    {


        return view('admin.lectures.edit', compact('lecture','lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Lesson $lesson,Lecture $lecture)
    {
        $this->validate($request,['title'=>'required']);
        $requestData = $request->all();

        $lecture->update($requestData);

        return redirect()->route('admin.classes.lectures.index',['lesson'=>$lesson->id])->with('flash_message', __('site.changes-saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy( Lesson $lesson,Lecture $lecture)
    {

        $lecture->delete();

        return back()->with('flash_message', __('site.record-deleted'));
    }

    public function files(Lecture $lecture){
        return view('admin.lectures.files',compact('lecture'));
    }

    private function getNextSortOrder(Lesson $lesson){
        $lastRecord = $lesson->lectures()->orderBy('sort_order','desc')->first();
        if($lastRecord){
            $sortOrder = $lastRecord->sort_order +1;
        }
        else{
            $sortOrder = 1;
        }
        return $sortOrder;
    }

}
