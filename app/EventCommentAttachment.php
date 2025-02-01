<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCommentAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['event_comment_id','file_path'];

    public function eventComment(){
        return $this->belongsTo(EventComment::class);
    }

}
