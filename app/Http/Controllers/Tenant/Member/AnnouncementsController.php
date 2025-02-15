<?php

namespace App\Http\Controllers\Tenant\Member;

use App\Http\Controllers\Tenant\Controller;

use App\Announcement;
use App\Mail\Generic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $announcements = getDepartment()->announcements()->whereRaw("match(title,content) against (? IN NATURAL LANGUAGE MODE)", [$keyword])->paginate($perPage);
        } else {
            $announcements = getDepartment()->announcements()->orderBy('pinned','desc')->latest()->paginate($perPage);
        }

        return view('member.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('administer');
        return view('member.announcements.create');
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
            'title'=>'required',
            'content'=>'required'
        ]);

        $this->authorize('administer');
        $requestData = $request->all();

        $requestData['user_id'] = Auth::user()->id;
        $requestData['department_id'] = getDepartment()->id;
        $requestData['content'] = saveInlineImages($requestData['content']);
        $announcement= Announcement::create($requestData);

        if($request->send==1){
            $subject=__('admin.announcement').': '.$requestData['title'];
            try{

                foreach(getDepartment()->users as $user){

                    Mail::to($user)->send(new Generic($subject,($requestData['content'])));
                }



              }
            catch (\Exception $ex){
                Log::error($ex->getMessage().$ex->getTraceAsString());
            }


        }

        return redirect('member/announcements')->with('flash_message',  __('admin.announcement').' '.__('admin.added'));
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
        $this->authorize('view',Announcement::find($id));
        $announcement = Announcement::findOrFail($id);

        return view('member.announcements.show', compact('announcement'));
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
        $this->authorize('administer');
        $this->authorize('update',Announcement::find($id));
        $announcement = Announcement::findOrFail($id);

        return view('member.announcements.edit', compact('announcement'));
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
            'title'=>'required',
            'content'=>'required'
        ]);

        $this->authorize('administer');
        $this->authorize('update',Announcement::find($id));
        $requestData = $request->all();
        $requestData['content'] = saveInlineImages($requestData['content']);
        $announcement = Announcement::findOrFail($id);
        $announcement->update($requestData);

        if($request->send==1){
            $subject=__('admin.announcement').': '.$requestData['title'];
            foreach(getDepartment()->users as $user){

                Mail::to($user)->send(new Generic($subject,($requestData['content'])));
            } 
        }

        return redirect('member/announcements')->with('flash_message',__('admin.changes-saved'));
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
        $this->authorize('delete',Announcement::find($id));
        $this->authorize('administer');
        Announcement::destroy($id);

        return redirect('member/announcements')->with('flash_message',  __('admin.announcement').' '.__('admin.deleted'));
    }

    public function pinned(Announcement $announcement,$pinned){
        $this->authorize('administer');
        $this->authorize('update',$announcement);
        $announcement->pinned = $pinned;
        $announcement->save();
        return back();
    }
}
