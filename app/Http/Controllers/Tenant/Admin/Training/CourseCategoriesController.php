<?php

namespace App\Http\Controllers\Tenant\Admin\Training;

use App\Http\Controllers\Tenant\Controller;
use App\Http\Requests;

use App\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        //$this->authorize('access','manage_course_categories');
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $coursecategories = CourseCategory::latest()->paginate($perPage);
        } else {
            $coursecategories = CourseCategory::latest()->paginate($perPage);
        }

        return view('admin.course-categories.index', compact('coursecategories','perPage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //$this->authorize('access','manage_course_categories');
        return view('admin.course-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //$this->authorize('access','manage_course_categories');
        $this->validate($request,[
           'name'=>'required',
            'sort_order'=>'nullable|integer'
        ]);
        $requestData = $request->all();

        CourseCategory::create($requestData);

        return redirect('admin/course-categories')->with('flash_message', __('site.changes-saved'));
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
        //$this->authorize('access','manage_course_categories');
        $coursecategory = CourseCategory::findOrFail($id);

        return view('admin.course-categories.show', compact('coursecategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        //$this->authorize('access','manage_course_categories');
        $coursecategory = CourseCategory::findOrFail($id);

        return view('admin.course-categories.edit', compact('coursecategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        //$this->authorize('access','manage_course_categories');
        $this->validate($request,[
            'name'=>'required',
            'sort_order'=>'nullable|integer'
        ]);
        $requestData = $request->all();

        $coursecategories = CourseCategory::findOrFail($id);
        $coursecategories->update($requestData);

        return redirect('admin/course-categories')->with('flash_message', __('site.changes-saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //$this->authorize('access','manage_course_categories');
        CourseCategory::destroy($id);

        return redirect('admin/course-categories')->with('flash_message', __('site.record-deleted'));
    }
}
