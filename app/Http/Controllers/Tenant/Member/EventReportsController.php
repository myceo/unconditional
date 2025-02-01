<?php

namespace App\Http\Controllers\Tenant\Member;

use App\Event;
use App\EventReport;
use App\EventReportAttachment;
use App\Http\Controllers\Tenant\Controller;

use App\Mail\Generic;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventReportsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $keyword = $request->get('search');

        $perPage = 50;
        $eventreports  = Auth::user()->eventReports()->whereHas('event',function (Builder $query) use ($keyword) {
            $query->where('department_id', getDepartment()->id);
            if(!empty($keyword)){
                $query->whereRaw("match(name,venue,description) against (? IN NATURAL LANGUAGE MODE)", [$keyword]);
            }
        })->latest()->paginate($perPage);

        return view('member.event-reports.index', compact('eventreports'));
    }





    public function create()
    {
        $msgId = Str::random(10);
        $events = getDepartment()->events()->orderBy('event_date','desc')->where('enable_reports',1)->limit(1000)->get();
        return view('member.event-reports.create',compact('msgId','events'));
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
        $this->validate($request,[
            'event_id'=>'required',
            'content'=>'required'
        ]);

        $requestData = $request->all();
        $requestData['content'] = saveInlineImages($requestData['content']);
        $eventReport= Auth::user()->eventReports()->create($requestData);

        $messageId = $requestData['msg_id'];

        //check for any attachments
        $path = TEMP_DIR.$messageId;

        //scan directory for files
        if(is_dir($path)) {
            $files = array_diff(scandir($path), array('.', '..'));
            if (count($files) > 0) {
                //check for directory
                $destDir = ATTACHMENT_PATH . '/' . $eventReport->id;
                if (!is_dir($destDir)) {
                    mkdir($destDir);
                }

                foreach ($files as $value) {
                    $newName = $destDir . '/' . $value;
                    $oldName = $path . '/' . $value;
                    $content = file_get_contents($oldName);
                    Storage::put($newName, $content);
                    // rename($oldName,$newName);
                    //attach record
                    $eventReport->eventReportAttachments()->create([
                        'file_path' => $newName
                    ]);

                }
            }
            @rmdir($path);

        }

            $this->eventReportNotification($eventReport);

        return redirect('member/event-reports')->with('flash_message', __('admin.changes-saved'));
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
        $eventreport = EventReport::findOrFail($id);

        return view('member.event-reports.show', compact('eventreport'));
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
        $this->authorize('update',EventReport::find($id));
        $eventreport = EventReport::findOrFail($id);
        $msgId = Str::random(10);
        $events = getDepartment()->events()->whereDate('event_date','<=',now()->toDateTimeString())->orderBy('event_date','desc')->where('enable_reports',1)->limit(1000)->get();

        return view('member.event-reports.edit', compact('eventreport','msgId','events'));
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
        $this->validate($request,[
            'event_id'=>'required',
            'content'=>'required'
        ]);
        $this->authorize('update',EventReport::find($id));
        $requestData = $request->all();

        $eventReport = EventReport::findOrFail($id);
        $eventReport->update($requestData);

        $messageId = $requestData['msg_id'];

        //check for any attachments
        $path = TEMP_DIR.$messageId;

        //scan directory for files
        if(is_dir($path)) {
            $files = array_diff(scandir($path), array('.', '..'));
            if (count($files) > 0) {
                //check for directory
                $destDir = ATTACHMENT_PATH . '/' . $eventReport->id;
                if (!is_dir($destDir)) {
                    mkdir($destDir);
                }

                foreach ($files as $value) {
                    $newName = $destDir . '/' . $value;
                    $oldName = $path . '/' . $value;
                    $content = file_get_contents($oldName);
                    Storage::put($newName, $content);
                    // rename($oldName,$newName);
                    //attach record
                    $eventReport->eventReportAttachments()->create([
                        'file_path' => $newName
                    ]);

                }
            }
            @rmdir($path);

        }

        if($request->has('event')){
            return redirect()->route('member.events.reports',['event'=>$request->event])->with('flash_message', __('admin.changes-saved'));
        }

        return redirect('member/event-reports')->with('flash_message', __('admin.changes-saved'));
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
        $eventReport = EventReport::find($id);
        $this->authorize('delete',$eventReport);
        foreach ($eventReport->eventReportAttachments as $attachment){
            if(!empty($attachment->file_path) && Storage::has($attachment->file_path))  Storage::delete($attachment->file_path);
        }
        $eventReport->delete();

        if(request()->has('event')){
            return redirect()->route('member.events.reports',['event'=>request()->event])->with('flash_message', __('admin.changes-saved'));
        }


        return redirect('member/event-reports')->with('flash_message', __('admin.record-deleted'));
    }

    public function deleteAttachment(EventReportAttachment $eventReportAttachment){
        $this->authorize('delete',$eventReportAttachment->eventReport);
        if(!empty($eventReportAttachment->file_path) && Storage::has($eventReportAttachment->file_path))  Storage::delete($eventReportAttachment->file_path);
        $eventReportAttachment->delete();
        return back()->with('flash_message', __('admin.record-deleted'));
    }



    private function eventReportNotification(EventReport $eventReport){

        //get and add all members of this event
        $title = __('admin.new-event-report');
        $message = __('admin.event-report-msg',['name'=>$eventReport->user->name,'event'=>$eventReport->event->name]);
        $users = [];


        foreach (getDepartmentAdmins() as $user){
            $users[$user->id] = $user;
        }

        if(isset($users[$eventReport->user->id])){
            unset($users[$eventReport->user->id]);
        }

        try{
                 Mail::to($users)->send(new Generic($title,($message)));
        }
        catch (\Exception $ex){
            Log::error($ex->getMessage().$ex->getTraceAsString());
        }



    }

    public function reportAttachment(EventReportAttachment $eventReportAttachment){
        $this->authorize('view',$eventReportAttachment->eventReport);

        $path = $eventReportAttachment->file_path;

        $content = Storage::get($path);

        header('Content-type: '.getMimeType($content,'str'));

        header('Content-Disposition: attachment; filename="'.basename($path).'"');

        echo $content;

        exit();
    }

    public function reportAttachments(EventReport $eventReport){
        $this->authorize('view',$eventReport);
        $zipname = 'attachments.zip';
        $zip = new \ZipArchive;
        $zip->open($zipname, \ZipArchive::CREATE);


        $deleteFiles = [];
        foreach ($eventReport->eventReportAttachments as $row) {
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

    public function viewImage(EventReportAttachment $eventReportAttachment){
        $this->authorize('view',$eventReportAttachment->eventReport);
        $file = $eventReportAttachment->file_path;

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
