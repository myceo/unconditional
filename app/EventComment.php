<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    use HasFactory;
    protected $fillable = ['event_id','user_id','content'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function eventCommentAttachments(){
        return $this->hasMany(EventCommentAttachment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
