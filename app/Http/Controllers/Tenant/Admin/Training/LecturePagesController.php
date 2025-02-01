<?php

namespace App\Http\Controllers\Tenant\Admin\Training;

use App\Http\Controllers\Tenant\Controller;
use App\Http\Requests;

use App\Lecture;
use App\LecturePage;
use Embed\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class LecturePagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request,Lecture $lecture)
    {
        return view('admin.lecture-pages.index', compact('lecture'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.lecture-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request,Lecture $lecture)
    {

        $rules = [
            'title'=>'required',
            'type'=>'required',
        ];
        switch ($request->type){
            case 'v':
                $rules['url'] = 'required';
                unset($rules['title']);
                break;
            case 'i':
                $rules['picture'] = 'required|image';
                break;
        }

        $this->validate($request,$rules);

        $requestData = $request->all();


        if(empty($request->sort_order)){
            $requestData['sort_order'] = $this->getNextSortOrder($lecture);
        }

        if($request->type=='v'){
            $info = Embed::create($request->url);
            if($info->type != 'video'){
                flashMessage(__('site.invalid-url'));
                return back()->withInput();
            }


            $requestData['title'] = $info->title;
            $requestData['content'] = $info->code;
        }
        elseif($request->type=='z'){
            $requestData['content'] = serialize($requestData);
        }
        elseif ($request->type=='i' && $request->files->has('picture')){
                $path = $request->picture->store(COURSE_FILES);
                $file = $path;
                $img = Image::make($file);
                $img->resize(env('LECTURE_IMAGE_SIZE',1000), null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($file);
                $requestData['content'] = $file;
        }
        elseif ($request->type=='q'){

                $requestData['content'] = $this->getQuizObject($requestData);
                $lecturePage = $lecture->lecturePages()->create($requestData);
                return redirect()->route('admin.lecture.edit-quiz',['lecturePage'=>$lecturePage->id]);
        }


        $lecture->lecturePages()->create($requestData);

        return redirect()->route('admin.lectures.lecture-pages.index',['lecture'=>$lecture->id])->with('flash_message', __('site.changes-saved'));
    }

    private function getNextSortOrder(Lecture $lecture){
        $lastRecord = $lecture->lecturePages()->orderBy('sort_order','desc')->first();
        if($lastRecord){
            $sortOrder = $lastRecord->sort_order +1;
        }
        else{
            $sortOrder = 1;
        }
        return $sortOrder;
    }


    private function getQuizObject($data){

        $info = new \stdClass();
        $info->name = $data['title'];
        $info->main =  $data['content'];
        $info->results = __('site.quiz-thanks');
        $info->level1 = __('site.excellent');
        $info->level2 = __('site.good');
        $info->level3 = __('site.average');
        $info->level4 = __('site.below-average');
        $info->level5 = __('site.poor');

        $obj = new \stdClass();
        $obj->json = new \stdClass();
        $obj->json->info = $info;
        $obj->json->questions = [];
        $obj->checkAnswerText = __('site.check-my-answer!');
        $obj->nextQuestionText = __('site.next').' &raquo;';
        $obj->backButtonText = '';
        $obj->completeQuizText = '';
        $obj->tryAgainText = '';
        $obj->questionCountText = __('site.question').' %current '.__('site.of').' %total';
        $obj->preventUnansweredText = __('site.you-must-select');
        $obj->questionTemplateText=  '%count. %text';
        $obj->scoreTemplateText= '%score / %total';
        $obj->nameTemplateText=  '<span>'.__('site.quiz').': </span>%name';
        $obj->skipStartButton= false;
        $obj->numberOfQuestions= null;
        $obj->randomSortQuestions= false;
        $obj->randomSortAnswers= false;
        $obj->preventUnanswered= false;
        $obj->disableScore= false;
        $obj->disableRanking= false;
        $obj->scoreAsPercentage= false;
        $obj->perQuestionResponseMessaging= true;
        $obj->perQuestionResponseAnswers= false;
        $obj->completionResponseMessaging= false;
        $obj->displayQuestionCount= true;
        $obj->displayQuestionNumber= true;

        $json = json_encode($obj);
        return $json;
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
        $lecturepage = LecturePage::findOrFail($id);

        return view('admin.lecture-pages.show', compact('lecturepage'));
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
        $lecturepage = LecturePage::findOrFail($id);

        return view('admin.lecture-pages.edit', compact('lecturepage'));
    }

    public function editQuiz(LecturePage $lecturePage){
       return view('admin.lecture-pages.quiz',compact('lecturePage'));
    }

    public function saveQuiz(Request $request,LecturePage $lecturePage){
        $info = new \stdClass();

        $obj = new \stdClass();
        $obj->json = new \stdClass();
        $obj->json->info = $info;

        //dd($request->post('content'));
        $quizPost = $request->post('content');
        foreach($quizPost as $key=>$value){
            $obj->$key = booleanValue($value);
        }

        unset($obj->json['questions']);
        $obj->json['questions'] = [];
        if(isset($quizPost['json']['questions'])){
            foreach($quizPost['json']['questions'] as $question){
                $questionObject = new \stdClass();
                $questionObject->q = $question['q'];
                $questionObject->correct = $question['correct'];
                $questionObject->incorrect = $question['incorrect'];
                if(isset($question['select_any'])){
                    $questionObject->select_any = booleanValue($question['select_any']);
                }

                if(isset($question['force_checkbox'])){
                    $questionObject->force_checkbox = booleanValue($question['force_checkbox']);
                }

                if(isset($question['a'])){
                    foreach($question['a'] as $option){
                        $optionObs = new \stdClass();
                        $optionObs->option= $option['option'];
                        $optionObs->correct = booleanValue(@$option['correct']);
                        $questionObject->a[] = $optionObs;
                    }
                }


                $obj->json['questions'][] = $questionObject;
            }
        }



        $lecturePage->content = json_encode($obj);
        $lecturePage->sort_order = $request->post('sort_order');
        $lecturePage->title = $request->post('title');
        $lecturePage->save();
        exit('true');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,Lecture $lecture, LecturePage $lecturePage)
    {

        $requestData = $request->all();
        if($lecturePage->type=='z'){
            $requestData['content'] = serialize($requestData);
        }
        elseif ($lecturePage->type=='i' && $request->files->has('picture')){
            @unlink($lecturePage->content);
            $path = $request->picture->store(COURSE_FILES);
            $file = $path;
            $img = Image::make($file);
            $img->resize(env('LECTURE_IMAGE_SIZE',1000), null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($file);
            $requestData['content'] = $file;
        }

        $lecturePage->fill($requestData)->save();


        return redirect()->route('admin.lectures.lecture-pages.index',['lecture'=>$lecture->id])->with('flash_message', __('site.changes-saved'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Lecture $lecture,LecturePage $lecturePage)
    {
        $lecturePage->delete();

        return back()->with('flash_message', __('site.record-deleted'));
    }


    public function deleteMultiple(Request $request){
        $count = 0;
        foreach(request()->all() as $key=>$value){
            if($value>0){
                try{
                    $lecturePage = LecturePage::find($value);
                    if($lecturePage){
                        $lecturePage->delete();
                        $count++;
                    }


                }
                catch(\Exception $ex){

                }

            }
        }
        session()->flash('flash_message',$count.' '.__('site.items-deleted'));
        return back();
    }

    public function importImages(Lecture $lecture){

        return view('admin.lecture-pages.import',compact('lecture'));
    }

    public function saveImages(Lecture $lecture,Request $request){
        $file =  $_FILES['picture'];
        $validator = Validator::make($request->all(),[
            'picture'=>'required|image'
        ]);

        if($validator->fails()){
            return response()->json([
                'picture'=>  [
                    'name'=> $file['name'],
                    'size'=> $file['size'],
                    'error'=>__('site.invalid-file')
                ]
            ]);
        }
        $name =  pathinfo($file['name'])['filename'];
        $requestData = [];

        $path = $request->picture->store(COURSE_FILES);
        $uploadFile = $path;
        $img = Image::make($uploadFile);
        $img->resize(env('LECTURE_IMAGE_SIZE',1000), null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save($uploadFile);
        $requestData['title'] = $name;
        $requestData['content'] = $uploadFile;
        $requestData['type'] = 'i';
        $requestData['sort_order'] = $this->getNextSortOrder($lecture);
        $lecture->lecturePages()->create($requestData);


        return response()->json([
            'files'=>  [[
                'name'=> $file['name'],
                'size'=> $file['size'],
                'thumbnailUrl'=>asset('/img/success.png')
            ]]
        ]);
    }


}
