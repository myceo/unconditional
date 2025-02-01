<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiDepartmentAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authToken = trim($request->header('Authorization'));
        $now = Carbon::now()->toDateTimeString();
        $user = \App\User::where('api_token',$authToken)->where('token_expires','>',$now)->first();
        if(!$user){
            return abort(401,'Unauthorized request: '.$authToken);
        }

        if ($user->role_id == 1){
            return $next($request);
        }

        $departmentId = $request->route('department');

       $admin = $user->departments()->where('department_id',$departmentId)->first()->pivot->department_admin;

        if($admin != 1){
            return abort(401,'Unauthorized request. Not a department admin: '.$authToken);
        }

        return $next($request);
    }
}
