<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirebaseToken extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','token','device_name'];


    public function user(){
        return $this->belongsTo(User::class);
    }

}
