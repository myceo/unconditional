<?php

namespace App\Http\Controllers\Tenant\Site;

use App\Course;
use App\Http\Controllers\Tenant\Controller;
use App\Test;
use App\TestOption;
use App\UserTest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index(){
        $perPage= 30;
        $tests= Test::publicTests()->latest()->paginate($perPage);

        return view('site.test.index',compact('tests','perPage'));
    }

    public function start(Test $test,$course=null){
        $user = Auth::user();
        //check if test is enabled
        if(empty($test->status)){
            abort(404);
        }

        if(!$user->canTakeTest($test)){
            abort(403);
        }

        //check if user has taken test
        if($user->userTests()->where('test_id',$test->id)->first() && $test->allow_multiple==0){
            return back()->with('flash_message',__('site.test-taken'));
        }

        $userTest = $user->userTests()->create([
            'test_id'=>$test->id,
            'complete'=>0,
            'score'=>0
        ]);

        $totalQuestions = $test->testQuestions()->count();

        return view('site.test.start',compact('test','userTest','totalQuestions','course'));
    }

    public function processTest(Request $request,UserTest $userTest,$course=null){
        //get user test record
        $user = Auth::user();

        if($user->id != $userTest->user_id || $userTest->complete==1){
            abort(403);
        }

        //check if user has exceeded the time

        if($userTest->test->minutes > 0 && Carbon::parse($userTest->created_at)->addMinutes($userTest->test->minutes+2)->lessThan(Carbon::now())){
            //complete user test and redirect
            $userTest->complete = 1;
            $userTest->save();
            return redirect()->route('site.tests')->with('flash_message',__('site.time-exceeded'));
        }

        //now store test results
        $questions = $userTest->test->testQuestions;
        $data = $request->all();
        $correct = 0;
        $totalQuestions = $userTest->test->testQuestions()->count();

        foreach($questions as $row){
            if(!empty($data['question_'.$row->id]))
            {
                $optionId = $data['question_'.$row->id];

                $userTest->userTestOptions()->create([
                    'test_option_id'=>$optionId
                ]);

                //check if option is correct
                $optionRow = TestOption::find($optionId);
                if($optionRow->is_correct==1){
                    $correct++;
                }

            }
        }

        //calculate score
        $score = ($correct/$totalQuestions)  * 100;
        //update
        $userTest->score = $score;
        $userTest->complete = 1;
        $userTest->save();

        //check if result showing is enabled

        if(!empty($course)){
            return redirect(route('lms.landing',['course'=>$course]).'?test=1')->with('flash_message',__('site.test-completed'));
        }

        if($userTest->test->show_result==1){
            return redirect()->route('site.tests.result',['userTest'=>$userTest->id]);
        }
        else{
            return redirect()->route('site.tests')->with('flash_message',__('site.test-completed'));
        }


    }

    public function result(UserTest $userTest){
        $user = Auth::user();

        if($user->id != $userTest->user_id || $userTest->complete!=1 || $userTest->test->show_result != 1){
            abort(403);
        }


        return view('site.test.result',compact('userTest'));

    }

    public function results(Test $test){
        if($test->show_result!=1){
            abort(403);
        }
        $perPage = 30;

        $results = Auth::user()->userTests()->where('test_id',$test->id)->latest()->paginate($perPage);
        return view('site.test.results',compact('results','perPage'));
    }

}
