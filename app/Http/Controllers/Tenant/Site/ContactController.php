<?php

namespace App\Http\Controllers\Tenant\Site;

use App\Http\Controllers\Tenant\Controller;
use App\Lib\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    use HelperTrait;

    public function __construct()
    {
        if(setting('general_contact_form')!=1){
            abort(401);
        }
    }

    public function form(){

            return view('site.contact.form');
    }

    public function process(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'message'=>'required',
            'captcha' => 'required|captcha'
        ]);

        $key = $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with(['flash_message' => 'Too many requests. Please try again later.','status'=>false]);
        }

        $msg = $request->message.'<br/><br/><small>('.__('site.msg-sent-from',['portal'=>getCurrentDomain()]).')</small>';

        $this->sendEmail(setting('general_contact_email'),$request->subject,$msg,[
            'address'=>$request->email,
            'name'=>$request->name
        ],null,false);


        return back()->with('flash_message',__('admin.message-sent'));
    }

}
