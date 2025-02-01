<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementComment extends Model
{
    use HasFactory;

    protected $fillable = ['announcement_id','user_id','content'];

    public function announcement(){
        return $this->belongsTo(Announcement::class);
    }

    public function announcementCommentAttachments(){
        return $this->hasMany(AnnouncementCommentAttachment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
