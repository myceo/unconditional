<?php

namespace App\Http\Controllers\Tenant\Member;

use App\Event;
use App\EventComment;
use App\EventCommentAttachment;
use App\Http\Controllers\Tenant\Controller;
use App\Mail\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventCommentsController extends Controller
{

    public function index(Event $event){
        $this->authorize('view',$event);
        $perPage = 50;
        $eventComments = $event->eventComments()->paginate($perPage);
        $msgId = Str::random(10);
        return view('member.event-comments.index',compact('event','eventComments','msgId'));
    }

    public function store(Request $request,Event $event){
        $this->authorize('view',$event);
        if(empty($event->enable_comments)){
            abort(403);
        }

        $this->validate($request,[
            'content'=>'required'
        ]);
        $content = saveInlineImages($request->post('content'));
       $eventComment= $event->eventComments()->create([
            'user_id'=>Auth::user()->id,
            'content'=>$content
        ]);
        //get email id
        $requestData = $request->all();
        $messageId = $requestData['msg_id'];

        //check for any attachments
        $path = TEMP_DIR.$messageId;

        //scan directory for files
        if(is_dir($path)){
            $files = array_diff(scandir($path), array('.', '..'));
            if(count($files) > 0){
                //check for directory
                $destDir = ATTACHMENT_PATH.'/'.$eventComment->id;
                if(!is_dir($destDir)){
                    mkdir($destDir);
                }

                foreach($files as $value){
                    $newName = $destDir.'/'.$value;
                    $oldName = $path.'/'.$value;
                    $content = file_get_contents($oldName);
                    Storage::put($newName,$content);
                    // rename($oldName,$newName);
                    //attach record
                    $eventComment->eventCommentAttachments()->create([
                        'file_path'=>$newName
                    ]);

                }
            }
            @rmdir($path);
        }


        $this->eventCommentNotification($eventComment);

        return redirect()->route('member.event-comments.index',['event'=>$event->id])->with('flash_messenger',__('admin.changes-saved'));
    }

    private function eventCommentNotification(EventComment $eventComment){

        //get and add all members of this event
        $title = __('admin.new-event-comment');
        $message = __('admin.event-comment-msg',['name'=>$eventComment->user->name,'event'=>$eventComment->event->name]);
        $users = [];

        foreach($eventComment->event->shifts as $shift){
            foreach($shift->users as $user){
                $users[$user->id] = $user;
            }
        }

        foreach (getDepartmentAdmins() as $user){
            $users[$user->id] = $user;
        }

        if(isset($users[$eventComment->user->id])){
            unset($users[$eventComment->user->id]);
        }

            try{
                     Mail::to($users)->send(new Generic($title,($message)));
            }
            catch (\Exception $ex){
                Log::error($ex->getMessage().$ex->getTraceAsString());
            }



    }

    public function commentAttachment(EventCommentAttachment $eventCommentAttachment){
        $this->authorize('view',$eventCommentAttachment->eventComment->event);

        $path = $eventCommentAttachment->file_path;

        $content = Storage::get($path);

        header('Content-type: '.getMimeType($content,'str'));

        header('Content-Disposition: attachment; filename="'.basename($path).'"');

        echo $content;

        exit();
    }

    public function commentAttachments(EventComment $eventComment){
        $this->authorize('view',$eventComment->event);
        $zipname = 'attachments.zip';
        $zip = new \ZipArchive;
        $zip->open($zipname, \ZipArchive::CREATE);


        $deleteFiles = [];
        foreach ($eventComment->eventCommentAttachments as $row) {
            $path =  $row->file_path;

            $tempUrl = Storage::providesTemporaryUrls()? Storage::temporaryUrl($path,now()->addHour()):$path;

            if (Storage::exists($path)) {
                $newFile = basename($path);
                copy($tempUrl,$newFile);
                $zip->addFile($newFile);

                $deleteFiles[] = $newFile;
            }



        }
        $zip->close();

        foreach($deleteFiles as $value){
            unlink($value);
        }

        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);
        unlink($zipname);
        exit();
    }

    public function viewImage(EventCommentAttachment $eventCommentAttachment){
        $this->authorize('view',$eventCommentAttachment->eventComment->event);
        $file = $eventCommentAttachment->file_path;

        try{
            $contents = Storage::get($file);
            if (!empty($contents)){
                $size = getimagesizefromstring($contents);
                $length = Storage::size($file);
                header('Content-Type: '.$size['mime']);
                header('Content-Length: '.$length);
                echo $contents;
            }
            else{
                readfile('themes/admin/assets/img/file.png');
            }
        }
        catch (\Exception $ex){
            Log::error($ex->getMessage().' | '.$ex->getTraceAsString());
            readfile('themes/admin/assets/img/file.png');

        }



    }

}
