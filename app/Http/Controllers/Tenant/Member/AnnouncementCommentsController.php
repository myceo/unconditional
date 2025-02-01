<?php

namespace App\Http\Controllers\Tenant\Member;

use App\Announcement;
use App\AnnouncementComment;
use App\AnnouncementCommentAttachment;
use App\Http\Controllers\Tenant\Controller;
use App\Mail\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementCommentsController extends Controller
{

    public function index(Announcement $announcement){
        $this->authorize('view',$announcement);
        $perPage = 50;
        $announcementComments = $announcement->announcementComments()->paginate($perPage);
        $msgId = Str::random(10);
        return view('member.announcement-comments.index',compact('announcement','announcementComments','msgId'));
    }

    public function store(Request $request,Announcement $announcement){
        $this->authorize('view',$announcement);
        if(empty($announcement->enable_comments)){
            abort(403);
        }

        $this->validate($request,[
            'content'=>'required'
        ]);
        $content = saveInlineImages($request->post('content'));
        $announcementComment= $announcement->announcementComments()->create([
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
                $destDir = ATTACHMENT_PATH.'/'.$announcementComment->id;
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
                    $announcementComment->announcementCommentAttachments()->create([
                        'file_path'=>$newName
                    ]);

                }
            }
            @rmdir($path);
        }


        $this->announcementCommentNotification($announcementComment);

        return redirect()->route('member.announcement-comments.index',['announcement'=>$announcement->id])->with('flash_messenger',__('admin.changes-saved'));
    }

    private function announcementCommentNotification(AnnouncementComment $announcementComment){

        //get and add all members of this announcement
        $title = __('admin.new-announcement-comment');
        $message = __('admin.announcement-comment-msg',['name'=>$announcementComment->user->name,'announcement'=>$announcementComment->announcement->title]);
        $users = [];

        foreach ($announcementComment->announcement->announcementComments as $comment){
            $users[ $comment->user_id] = $comment->user;
        }

        foreach (getDepartmentAdmins() as $user){
            $users[$user->id] = $user;
        }

        if(isset($users[$announcementComment->user->id])){
            unset($users[$announcementComment->user->id]);
        }

        try{
                 Mail::to($users)->send(new Generic($title,($message)));
        }
        catch (\Exception $ex){
            Log::error($ex->getMessage().$ex->getTraceAsString());
        }

    }

    public function commentAttachment(AnnouncementCommentAttachment $announcementCommentAttachment){
        $this->authorize('view',$announcementCommentAttachment->announcementComment->announcement);

        $path = $announcementCommentAttachment->file_path;

        $content = Storage::get($path);

        header('Content-type: '.getMimeType($content,'str'));

        header('Content-Disposition: attachment; filename="'.basename($path).'"');

        echo $content;

        exit();
    }

    public function commentAttachments(AnnouncementComment $announcementComment){
        $this->authorize('view',$announcementComment->announcement);
        $zipname = 'attachments.zip';
        $zip = new \ZipArchive;
        $zip->open($zipname, \ZipArchive::CREATE);


        $deleteFiles = [];
        foreach ($announcementComment->announcementCommentAttachments as $row) {
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

    public function viewImage(AnnouncementCommentAttachment $announcementCommentAttachment){
        $this->authorize('view',$announcementCommentAttachment->announcementComment->announcement);
        $file = $announcementCommentAttachment->file_path;

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
