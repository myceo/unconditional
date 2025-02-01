<?php


namespace App\Pivots;


use App\Department;
use App\Event;
use App\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DepartmentUser extends  Pivot
{
/*    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function events(){
        return $this->hasManyThrough(Event::class,Department::class);
    }*/


}
