<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReportAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['event_report_id','file_path'];

    public function eventReport(){
        return $this->belongsTo(EventReport::class);
    }
}
