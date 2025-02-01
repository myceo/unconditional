<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementCommentAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['announcement_comment_id','file_path'];

    public function announcementComment(){
        return $this->belongsTo(AnnouncementComment::class);
    }

}
