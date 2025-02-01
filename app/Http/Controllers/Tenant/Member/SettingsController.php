<?php

namespace App\Http\Controllers\Tenant\Member;

use App\Lib\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{

    use HelperTrait;

    public function general(){
        $department = getDepartment();

        return view('member.settings.general',compact('department'));
    }

    public function removePicture(){
        $dept = getDepartment();
        //@unlink($dept->picture);
        if(!empty($dept->picture) && Storage::has($dept->picture)) Storage::delete($dept->picture);
        $dept->picture = null;
        $dept->save();
        return back()->with('flash_message',__('admin.picture').' '.__('admin.deleted'));
    }


    public function saveSettings(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'picture' => 'file|max:10000|mimes:jpeg,png,gif',
        ]);

        $requestData = $request->all();
        $requestData['description'] = saveInlineImages($requestData['description']);


        $department = getDepartment();

        if($request->hasFile('picture')){

            if(!empty($department->picture) && Storage::has($department->picture))   Storage::delete($department->picture);
            $tempFile = $request->file('picture')->path();

            $img = Image::make($tempFile);

            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($tempFile);

            $path = Storage::putFile(DEPARTMENTS,$tempFile);

            $requestData['picture'] = $path;
        }

        $department->update($requestData);



        return back()->with('flash_message', __('admin.department').' '.__('admin.updated'));

    }





}
