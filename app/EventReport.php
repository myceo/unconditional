<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReport extends Model
{
    use HasFactory;
    protected $fillable = ['event_id','user_id','content'];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function eventReportAttachments(){
        return $this->hasMany(EventReportAttachment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
