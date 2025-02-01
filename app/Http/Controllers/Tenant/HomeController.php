<?php

namespace App\Http\Controllers\Tenant;

use App\Category;
use App\Department;
use App\Lib\CronJobs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
   //     $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function site(Request $request){

        if(!file_exists('../storage/installed')){
            return redirect('/install');
        }

        //get department list
        $keyword = $request->get('search');
        $category = $request->get('category');
        $perPage = 9;

        $departments = Department::inRandomOrder()->limit($perPage)->where('visible',1);

        if(!empty($category) && Category::find($category)){
            $categoryName = Category::find($category)->name;

            $departments = $departments->whereHas('categories',function($q) use ($category){
                $q->where('id',$category);
            });

        }
        else{
            $categoryName = null;
        }

        $departments = $departments->get();

        $output = compact('departments','categoryName');
        if(Auth::check()){
            $user = Auth::user();
            $output['emails'] =  $user->receivedEmails()->latest()->limit(5)->get();
            $output['events'] =  $user->events()->where('event_date' , '>=' , Carbon::yesterday()->toDateTimeString())->orderBy('event_date')->limit(5)->get();

            $output['announcements'] =    $user->announcements()->latest()->limit(5)->get();

            $output['forumTopics'] =  $user->forumTopics()->latest()->limit(5)->get();
            $output['shifts'] = $user->shifts()->whereHas('event',function($q){
                $q->where('event_date' , '>=' , Carbon::yesterday()->toDateTimeString())->orderBy('event_date');
            })->limit(10)->get();

        }


        return view('welcome', $output);
    }

    public function cron(){
        $cronJobs = new CronJobs();
        $cronJobs->deleteTempFiles();
        $cronJobs->upcomingEvents();
        echo 'Cron Complete';
    }

    public function privacy(){
        return view('privacy');
    }

    public function test(){

        echo 'done';
    }

    public function migrate(){
        //run migrations
        echo Artisan::call('migrate', array('--path' => 'database/migrations', '--force' => true));
        echo '<br/>Done migrating';
    }

    private function saveUserPicture(User $user,$photoUrl){
        if(!empty($user->picture)){
            return true;
        }

        if(empty($photoUrl)){
            return true;
        }

        //download the image
        try{
            $remoteName = basename($photoUrl);
            $filename = time().'-'.$remoteName;
            $tempImage = tempnam(sys_get_temp_dir(), $filename);
            copy($photoUrl, $tempImage);

            $path_parts = pathinfo($photoUrl);

            $extension = $path_parts['extension'];


            $file = 'uploads/members/'.uniqid().'.'.$extension;
            $img = Image::make($tempImage);

            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($file);

            $user->picture = $file;
            $user->save();
            @unlink($tempImage);

        }
        catch(\Exception $ex){

        }



    }

}

