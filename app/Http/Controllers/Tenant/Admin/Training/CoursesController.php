<?php

namespace App\Http\Controllers\Tenant\Admin\Training;

use App\Course;
use App\Http\Controllers\Tenant\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CoursesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {

        $keyword = $request->get('search');
        $perPage = 24;
        $courses = Course::query();

        $sort = $request->get('sort', null);
        if (empty($sort)) {
            $sort=null;
        }

        $payment = $request->get('payment', null);
        if (!is_numeric($payment)) {
            $payment=null;
        }

        $status = $request->get('status',null);

        $visibility = $request->get('visibility',null);



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

        if($status!=null){
           $courses = $courses->where('enabled',$status);
        }

        if($visibility!=null){
            $courses = $courses->where('all_users',$visibility);
        }


        $payment = $request->get('payment',null);
        if($payment != null){
            $courses = $courses->where('payment_required',$payment);
        }

        $courses =   $courses->paginate($perPage)->withQueryString();

        return view('admin.courses.index',compact('courses'));
    }


    public function create()
    {

        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCourseRequest $request)
    {

            $data = $request->all();
            $course = Course::create($data);

            //assign tests
            $course->tests()->attach($request->tests);

            $course->departments()->attach($request->departments);

            //assign to categories
            $course->courseCategories()->attach($request->categories);



            $course->courseInstructors()->attach($request->instructors);


            //add files
            if($request->files->has('course_files')){
                $fileBag = $request->files->get('course_files');

                foreach($fileBag as $key=>$file){

                    $path = $request->file('course_files')[$key]->store(COURSE_FILES);
                    //$path =$path;
                    $course->courseFiles()->create([
                        'path'=>$path,
                        'name'=>$file->getClientOriginalName()
                    ]);
                }
            }

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
                $course->picture = $file;

            }

            $course->save();

            return redirect()->route('admin.courses.index')->with('flash_message',__('site.changes-saved'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\View\View
     */
    public function edit(Course $course)
    {

        return view('admin.courses.edit',compact('course'));
    }


    public function update(UpdateCourseRequest $request, Course $course)
    {

        $course->fill($request->all());
        //assign tests
        $course->tests()->sync($request->tests);

        $course->departments()->sync($request->departments);

        //assign to categories
        $course->courseCategories()->sync($request->categories);


        $course->courseInstructors()->sync($request->instructors);


        //add files
        if($request->files->has('course_files')){
            $fileBag = $request->files->get('course_files');

            foreach($fileBag as $key=>$file){

                $path = $request->file('course_files')[$key]->store(COURSE_FILES);
              //  $path =$path;
                $course->courseFiles()->create([
                    'path'=>$path,
                    'name'=>$file->getClientOriginalName()
                ]);
            }
        }

        //check if image is present
        if($request->files->has('picture')){
            @unlink($course->picture);
            $path = $request->picture->store(COURSE_FILES);
            $file = $path;
            $img = Image::make($file);

            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($file);
            $course->picture = $file;
        }

        $course->save();


        return redirect()->route('admin.courses.index')->with('flash_message',__('site.changes-saved'));

    }


    public function destroy(Course $course)
    {

        //delete image
        @unlink($course->picture);
        //delete files
        foreach ($course->courseFiles as $file){
            if(!empty($file->path) && Storage::has($file->path))   Storage::delete($file->path);
        }
        $course->delete();

        return redirect()->route('admin.courses.index')->with('flash_message',__('site.record-deleted'));

    }

    public function removeImage(Course $course){

        @unlink($course->picture);
        $course->picture = null;
        $course->save();
        flashMessage(__('site.changes-saved'));
        return back();
    }

    public function students(Course $course){

        return view('admin.courses.students',compact('course'));
    }

    public function addStudents(Request $request,Course $course){
        foreach ($request->users as $user){

            if(!$course->users()->find($user)){
                $course->users()->attach($user);
            }
        }
        flashMessage(__('site.changes-saved'));
        return back();
    }

    public function certificate(Course $course){
         return view('admin.courses.certificate',compact('course'));
    }

    public function updateCertificate(Request $request,Course $course){
        $this->validate($request,[
            'certificate_enabled'=>'sometimes|required',
            'certificate_orientation'=>'sometimes|required',
            'file'=>'sometimes|nullable|image|max:'.env('MAX_UPLOAD_SIZE','10240'),
            'certificate_html'=>'sometimes|required'
        ]);
        //check if image is present

        if($request->files->has('file')){
            if(!empty($course->certificate_image) && file_exists($course->certificate_image)){
                @unlink($course->certificate_image);
            }
            $path = $request->file->store(COURSE_FILES);
            $file = $path;
            $img = Image::make($file);

            $img->resize(1500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($file);
            $course->certificate_image = $file;
        }
        $course->fill($request->all());

        $course->save();

        flashMessage(__('site.changes-saved'));
        return back();

    }

    public function clearCertificateImage(Request $request,Course $course){
        if(!empty($course->certificate_image) && file_exists($course->certificate_image)){
            @unlink($course->certificate_image);
        }
        $course->certificate_image = null;
        $course->save();
        flashMessage(__('site.changes-saved'));
        return back();
    }

    public function duplicate(Course $course){
        $course->replicateRow();
        flashMessage(__('site.record-duplicated'));
        return back();
    }

    public function play(Course $course){
        $user = Auth::user();
        if(!$user->courses()->find($course->id)){
            $user->courses()->attach($course->id);
        }
        return redirect()->route('lms.landing',['course'=>$course->id]);
    }

    public function message(Request $request,Course $course){
        $this->validate($request,[
            'subject'=>'required',
            'message'=>'required'
        ]);

        foreach ($course->users as $user){
            sendEmail($user->email,$request->subject,$request->message);

        }

        flashMessage(__('site.message-sent'));
        return back();

    }

}
