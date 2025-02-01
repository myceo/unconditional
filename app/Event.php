<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
       protected $fillable = ['department_id','name','venue','description','event_date','notifications','accept_volunteers','enable_comments','enable_reports'];

       public function department(){
           return $this->belongsTo(Department::class);
       }

       public function shifts(){
           return $this->hasMany(Shift::class);
       }


        public function rejections(){
            return $this->hasManyThrough(Rejection::class,Shift::class);
        }

        public function eventComments(){
           return $this->hasMany(EventComment::class);
        }

        public function eventReports(){
           return $this->hasMany(EventReport::class);
        }

        public function eventCommentAttachments(){
           return $this->hasManyThrough(EventCommentAttachment::class,EventComment::class);
        }

        public function eventReportAttachments(){
           return $this->hasManyThrough(EventReportAttachment::class,EventReport::class);
        }

}
