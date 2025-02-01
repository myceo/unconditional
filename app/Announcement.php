<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable= ['user_id','department_id','title','content','pinned'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }


    public function announcementComments(){
        return $this->hasMany(AnnouncementComment::class);
    }

    public function announcementCommentAttachments(){
        return $this->hasManyThrough(AnnouncementCommentAttachment::class,AnnouncementComment::class);
    }

}
