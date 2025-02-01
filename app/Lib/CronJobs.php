<?php
namespace App\Lib;

use App\Department;
use App\Event;
use App\ForumTopic;
use App\Mail\UpcomingShift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CronJobs
{
    use HelperTrait;

    public function deleteTempFiles(){
        $path = '../storage/tmp';

        $objects = scandir($path);
        foreach ($objects as $object) {
             $dir = $path.'/'.$object;
            if(is_dir($dir) && $object !='..' && $object !='.'){
                if (filemtime($dir) < time() - 86400) {
                    deleteDir($dir);
                }
            }

        }
    }

    public function upcomingEvents(){

        $events = Event::where('event_date','>',Carbon::now()->toDateTimeString())->where('event_date' , '<=' , Carbon::now()->addDays(3)->toDateTimeString())->get();

        foreach($events as $event){
            foreach($event->shifts as $shift){
                //get users for this shift
                foreach($shift->users as $user){
                    try{
                        Mail::to($user->email)->send(New UpcomingShift($shift,$user));
                        echo 'Mail sent to '.$user->name.'<br/>';
                    }
                    catch(\Exception $ex){

                    }
                }
            }
        }

    }

    public function newForumTopics(){


        foreach (Department::limit(1000)->get() as $department){            //first get all topics created within the last hour

            $totalTopics = $department->forumTopics()->where('created_at','>=',Carbon::now()->subHour())->count();
            if($totalTopics > 0){
                $topics = ForumTopic::where('created_at','>=',Carbon::now()->subHour())->limit(500)->get();
                $topicList = [];
                foreach($topics as $topic){
                    $topicList[] = $topic->topic;
                }
                $body = join(',',$topicList);
                $body = limitLength($body,200);
                $title = __('admin.new-topics',['total'=>$totalTopics]);
                if($totalTopics==1){
                    $title= __('admin.new-topic');
                }

                foreach ($department->user as $user){
                    $this->sendEmail($user->email,$title,$body);
                }


            }
        }

    }

    public function forumReplies(){

        foreach (Department::limit(1000)->get() as $department){            //first get all topics created within the last hour

            $totalTopics = $department->forumTopics()->where('updated_at','>=',Carbon::now()->subHour())->count();
            if($totalTopics > 0){
                $topics = ForumTopic::where('updated_at','>=',Carbon::now()->subHour())->limit(500)->get();
                foreach ($topics as $topic){
                    $totalThreads = $topic->forumThreads()->count();
                    if($totalThreads < 2){
                        continue;
                    }

                    //get total for last hour
                    $totalRecent = $topic->forumThreads()->select('user_id')->distinct()->where('updated_at','>=',Carbon::now()->subHour())->count();
                    if($totalRecent > 0){

                        if($totalRecent==1){
                            $thread = $topic->forumThreads()->select('user_id')->distinct()->where('updated_at','>=',Carbon::now()->subHour())->first();
                            $userId= $thread->user_id;
                            $threads= $topic->forumThreads()->select('user_id')->distinct()->where('user_id','!=',$userId)->get();
                        }
                        else{
                            //get users
                            $threads= $topic->forumThreads()->select('user_id')->distinct()->get();
                        }

                        $body = __('admin.new-replies',['total'=>$totalRecent,'topic'=>$topic->topic]);
                        $title = __('admin.new-reply');

                        foreach ($threads as $thread){
                            $this->sendEmail($thread->user->email,$title,$body);
                        }

                    }

                }


            }
        }

    }

    public function birthdays(){
        $departments = Department::where('anniversary_notifications',1)->limit(5000)->get();
        foreach ($departments as $department){
            $today=now();
            $userList =[];
            //now get all department users whose birthday is today
            $birthdayUsers = $department->users()->whereMonth('date_of_birth',$today->month)->whereDay('date_of_birth',$today->day)->limit(2000)->get();
            $departmentUsers = $department->users()->limit(2000)->get();
            foreach ($birthdayUsers as $birthdayUser){
                $subject = __('site.new-dept-birthday',['dept'=>$department->name]);
                $message = __('site.birthday-message',['name'=>$birthdayUser->name]);

                foreach ($departmentUsers as $departmentUser){

                    if($birthdayUser->id == $departmentUser->id){
                        $title = __('site.happy-birthday');
                        $msg = __('site.happy-birthday-msg',['name'=>$departmentUser->name]);
                        try{
                            $this->sendEmail($departmentUser->email,$title,$msg);
                        }
                        catch (\Exception $ex){
                            Log::error($ex->getMessage().':'.$ex->getTraceAsString());
                        }


                     }
                    else{
                        $userList[] = $departmentUser;
                        $this->sendEmail($departmentUser->email,$subject,$message);
                    }

                }
             }
        }

    }

    public function anniversaries(){
        $departments = Department::where('anniversary_notifications',1)->limit(5000)->get();
        foreach ($departments as $department){
            $today=now();
            $userList =[];
            //now get all department users whose birthday is today
            $anniversaryUsers = $department->users()->whereMonth('wedding_anniversary',$today->month)->whereDay('wedding_anniversary',$today->day)->limit(2000)->get();
            $departmentUsers = $department->users()->limit(2000)->get();
            foreach ($anniversaryUsers as $anniversaryUser){
                $subject = __('site.new-dept-anniversary',['dept'=>$department->name]);
                $message = __('site.anniversary-message',['name'=>$anniversaryUser->name]);

                foreach ($departmentUsers as $departmentUser){

                    if($anniversaryUser->id == $departmentUser->id){
                        $title = __('site.happy-anniversary');
                        $msg = __('site.happy-anniversary-msg',['name'=>$departmentUser->name]);
                        try{
                            $this->sendEmail($departmentUser->email,$title,$msg);
                        }
                        catch (\Exception $ex){
                            Log::error($ex->getMessage().':'.$ex->getTraceAsString());
                        }

                    }
                    else{
                        $userList[] = $departmentUser;
                        try{
                            $this->sendEmail($departmentUser->email,$subject,$message);
                        }
                        catch (\Exception $ex){
                            Log::error($ex->getMessage().':'.$ex->getTraceAsString());
                        }

                    }

                }



            }
        }
    }

    public function applications(){
        $departments = Department::limit(5000)->get();
        foreach ($departments as $department){
            $count = $department->applications()->whereDate('created_at', '=', \Carbon\Carbon::yesterday()
                ->format('Y-m-d'))->count();
            if($count>0){
                $title = __('admin.new-applications');
                $message = __('admin.new-applications-message',['count'=>$count]);
                foreach ($this->getDepartmentAdmins($department) as $user){
                    $this->sendEmail($user->email,$title,$message);
                }
            }
        }
    }

    private function getDepartmentAdmins(Department $department){
        return $department->users()->wherePivot('department_admin', 1)->get();
    }

}
