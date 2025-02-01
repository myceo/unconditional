<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Field;
use App\Lib\HelperTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AccountController extends Controller
{
    use HelperTrait;

    public function profile(){

        $user = Auth::user();
        $member = $user;
        return view('admin.account.profile',compact('user','member'));
    }

    public function saveProfile(Request $request){

        $rules = [
            'name'=>'required',
            'email'=>'required',
            'gender'=>'required',
            'telephone'=>'required',
            'picture' => 'file|max:10000|mimes:jpeg,png,gif',
        ];
        if(setting('general_enable_birthday')==1){
            $rules['date_of_birth'] = 'required';
        }

        $this->validate($request,$rules);


        $requestData = $request->all();
        $user = Auth::user();

        //check for photo
        if($request->hasFile('picture')){
            //@unlink($user->picture);
            if(!empty($user->picture) && Storage::has($user->picture))   Storage::delete($user->picture);


            $tempFile = $request->file('picture')->path();

            $img = Image::make($tempFile);

            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($tempFile);

            $path = Storage::putFile(MEMBERS,$tempFile);


            $requestData['picture'] = $path;
        }
        else{
            $requestData['picture'] = $user->picture;
        }


        $requestData['telephone'] = getPhoneNumber($requestData['f_telephone']);

        $user->fill($requestData);
        $user->save();

        $customValues = [];
        //attach custom values
        foreach(Field::orderBy('sort_order','asc')->get() as $field){
            if(isset($requestData[$field->id]))
            {
                $customValues[$field->id] = ['value'=>$requestData[$field->id]];
            }


        }

        $user->fields()->sync($customValues);

        return back()->with('flash_message',__('admin.changes-saved'));
    }


    public function password(){
        return view('admin.account.password');
    }

    public function savePassword(Request $request){
        $this->validate($request,[
            'password'=>'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('flash_message',__('admin.changes-saved'));
    }

    public function removePicture(){
        $user = Auth::user();
       // @unlink($user->picture);
        if(!empty($user->picture) && Storage::has($user->picture))   Storage::delete($user->picture);
        $user->picture = null;
        $user->save();
        return back()->with('flash_message',__('admin.picture').' '.__('admin.deleted'));
    }

    public function token(){
        $user = Auth::user();
        return view('admin.account.token',compact('user'));
    }

    public function setToken(){
        $user = Auth::user();
        do{
            $token = bin2hex(random_bytes(16));
        }while(!User::where('api_token',$token));

        $user->api_token = $token;
        $user->token_expires = Carbon::now()->addYears(10)->toDateTimeString();
        $user->save();
        return back()->with('flash_message',__('admin.changes-saved'));
    }

    public function deleteToken(){
        $user = Auth::user();
        $user->api_token = '';
        $user->token_expires = Carbon::now()->addYears(10)->toDateTimeString();
        $user->save();
        return back()->with('flash_message',__('admin.changes-saved'));
    }

}
