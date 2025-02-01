<?php

namespace App\Http\Controllers\Tenant\Api\Admin;

use App\Department;
use App\Http\Controllers\Tenant\Controller;
use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{

    public function index(Request $request){
        $keyword = $request->get('search');
        $department = $request->get('department');
        $perPage = !empty($request->get('page_size'))? $request->get('page_size') : 25;
        $deptName = null;
        $query = User::select('id','name','email','role_id','telephone','gender','picture','about','status','created_at','updated_at');
        if (!empty($keyword)) {
            $members = $query->whereRaw("match(name,email,telephone) against (? IN NATURAL LANGUAGE MODE)", [$keyword]);
        } else {
            $members = $query->orderBy('name');
        }

        if(!empty($department) && Department::find($department)){
            $deptName = Department::find($department)->name;

            $members = $members->whereHas('departments',function($q) use ($department){
                $q->where('id',$department);
            });


        }

        $count  = $members->count();
        $members = $members->paginate($perPage);
        $members = $members->toArray();

        foreach ($members['data'] as $key=>$member){

            $data = User::find($member['id'])->fields()->select('id','name','type')->get()->toArray();
            if (!empty($member['picture'])){
                $member['picture'] = asset($member['picture']);
            }

            $member['custom'] = $data;
            $members['data'][$key] = $member;

        }

        return response()->json(compact('members','deptName','count'));


    }

}
