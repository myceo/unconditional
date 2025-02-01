<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Tenant\Controller;
use App\LoginToken;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    private $authKey = 'auth-url';

    public function social(Request $request){
        $token = $request->token;
        $socialUser = Socialite::driver('google')->userFromToken($token);

        if(!$socialUser){
            return redirect()->route('login')->with('flash_message','Invalid user');
        }


        $authUser = User::where('email', $socialUser->getEmail())->first();

        if($authUser){
            Auth::login($authUser);
            if(strlen(getRedirectLink())>3){
                return redirect(getRedirectLink());
            }
            else{
                return redirect('/home');
            }
        }
        elseif(setting('general_enable_registration')==1){
            $userClass = new \stdClass();
            $userClass->name = $socialUser->getName();
            $userClass->email = $socialUser->getEmail();
            $userClass->phone = '0';
            $userClass->gender = 'm';
            $userClass->photoURL= $socialUser->getAvatar();

            //store user in session
            session()->put('social_user',serialize($userClass));
            return redirect()->route('social.form');
        }
        else{
            return redirect()->route('login')->with('flash_message',__('auth.registration-disabled'));
        }

    }

    public function billing(Request $request,$token){
        $loginToken = LoginToken::where('token',$token)->first();
        if(!$loginToken){
            abort(404);
        }
        $loginToken->delete();
        //get billing account
        $user = User::where('is_billing',1)->first();
        if(!$user){
            abort(404);
        }
        $url = route('admin.dashboard');
        if($request->has('wizard')){
            $url.='?wizard';
        }

        Auth::login($user);
        return redirect($url);

    }

}
