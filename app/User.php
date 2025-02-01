<?php

namespace App;

use App\Pivots\DepartmentUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','telephone','gender','picture','about','status','api_token','token_expires',
        'notify_events','notify_messages','notify_announcements','notify_forum_topics','notify_forum_replies','notify_anniversaries','notify_applications',
        'date_of_birth','wedding_anniversary'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $showToken = false;
    public $showDepartments = false;


    public function teams(){
        return $this->belongsToMany(Team::class);
    }

    public function departments(){
        return $this->belongsToMany(Department::class)->withPivot('department_admin');
    }

    public function departmentFields(){
        return $this->belongsToMany(DepartmentField::class)->withPivot('value');
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function fields(){
        return $this->belongsToMany(Field::class)->withPivot('value');
    }

    public function emails(){
        return $this->hasMany(Email::class);
    }

    public function receivedEmails(){
        return $this->belongsToMany(Email::class)->withPivot('read');
    }

    public function sms(){
        return $this->hasMany(Sms::class);
    }

    public function receivedSms(){
        return $this->belongsToMany(Sms::class);
    }

    public function shifts(){
        return $this->belongsToMany(Shift::class)->withPivot('tasks');
    }

    public function rejections(){
        return $this->hasMany(Rejection::class);
    }

    public function downloads(){
        return $this->hasMany(Download::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function firebaseTokens(){
        return $this->hasMany(FirebaseToken::class);
    }

    public function scopeBirthDayBetween ($query, Carbon $from, Carbon $till)
    {
        $fromMonthDay = $from->format('m-d');
        $tillMonthDay = $till->format('m-d');
        if ($fromMonthDay <= $tillMonthDay) {
            //normal search within the one year
            $query->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN '{$fromMonthDay}' AND '{$tillMonthDay}'");
        } else {
            //we are overlapping a year, search at end and beginning of year
            $query->where(function ($query) use ($fromMonthDay, $tillMonthDay) {
                $query->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN '{$fromMonthDay}' AND '12-31'")
                    ->orWhereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN '01-01' AND '{$tillMonthDay}'");
            });
        }
    }

    public function scopeAnniversaryBetween ($query, Carbon $from, Carbon $till)
    {
        $fromMonthDay = $from->format('m-d');
        $tillMonthDay = $till->format('m-d');
        if ($fromMonthDay <= $tillMonthDay) {
            //normal search within the one year
            $query->whereRaw("DATE_FORMAT(wedding_anniversary, '%m-%d') BETWEEN '{$fromMonthDay}' AND '{$tillMonthDay}'");
        } else {
            //we are overlapping a year, search at end and beginning of year
            $query->where(function ($query) use ($fromMonthDay, $tillMonthDay) {
                $query->whereRaw("DATE_FORMAT(wedding_anniversary, '%m-%d') BETWEEN '{$fromMonthDay}' AND '12-31'")
                    ->orWhereRaw("DATE_FORMAT(wedding_anniversary, '%m-%d') BETWEEN '01-01' AND '{$tillMonthDay}'");
            });
        }
    }

    public function eventComments(){
        return $this->hasMany(EventComment::class);
    }

    public function eventReports(){
        return $this->hasMany(EventReport::class);
    }


    public function events(){
        return $this->hasManyThrough(Event::class,DepartmentUser::class,'user_id','department_id','id','department_id');
    }

    public function announcements(){
        return $this->hasManyThrough(Announcement::class,DepartmentUser::class,'user_id','department_id','id','department_id');

    }

    public function forumTopics(){
        return $this->hasManyThrough(ForumTopic::class,DepartmentUser::class,'user_id','department_id','id','department_id');

    }

    public function flags(){
        return $this->hasMany(Flag::class);
    }

    public function blockedUsers(){
        return $this->hasMany(BlockedUser::class);
    }


    public function courses(){
        return $this->belongsToMany(Course::class);
    }

    public function lectures(){
        return $this->belongsToMany(Lecture::class);
    }

    public function lessons(){
        return $this->belongsToMany(Lesson::class);
    }


    public function scopeNonAdmins($query){
        return $query->where('role_id','!=',1);
    }

    public function completedLesson(Lesson $lesson){
        $completed = true;

        if($lesson->lectures()->count()==0){
            return false;
        }

        foreach ($lesson->lectures as $lecture){
            if(!$this->completedLecture($lecture)){
                $completed = false;
            }
        }
        return $completed;
    }

    public function completedLecture(Lecture $lecture){
        return $this->lectures()->find($lecture->id);
    }


    public function testTaken(Test $test){
        return $this->userTests()->where('test_id',$test->id)->exists();
    }

    public function testPassed(Test $test){
        return $this->userTests()->where('test_id',$test->id)->where('score','>=',$test->passmark)->exists();
    }


    public function canTakeTest(Test $test){
        if(empty($test->private) && !empty($test->status)){
            return true;
        }


        foreach ($this->courses as $course){
            if($course->tests()->find($test->id)){
                return true;
            }
        }

        return false;

    }

    public function userTests(){
        return $this->hasMany(UserTest::class);
    }


}
