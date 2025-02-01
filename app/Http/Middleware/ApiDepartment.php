<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiDepartment
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

        $department = $user->departments()->where('department_id',$departmentId)->first();

        //user is not a member of this department
        if(!$department){
            return abort(401,'Unauthorized request. Does not belong to department: '.$authToken);
        }


        return $next($request);
    }
}
