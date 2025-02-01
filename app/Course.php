<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','short_description','introduction','effort','length','enabled','start_date','end_date','closes_on','capacity','enforce_capacity','enforce_order','certificate_html','certificate_image','certificate_enabled','certificate_orientation','pinned','all_users'];

    public function courseCategories(){
        return $this->belongsToMany(CourseCategory::class);
    }

    public function tests(){
        return $this->belongsToMany(Test::class);
    }

    public function courseFiles(){
        return $this->hasMany(CourseFile::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }


    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function courseInstructors(){
        return $this->belongsToMany(User::class,'course_instructor');
    }

    public function replicateRow(){
        $clone = $this->replicate();
        $clone->push();

        if(!empty($this->picture) && file_exists($this->picture)){
            $newName = getNewFilePath($this->picture);
            copy($this->picture,$newName);
            $clone->picture = $newName;
        }

        if(!empty($this->certificate_image) && file_exists($this->certificate_image)){
            $newName = getNewFilePath($this->certificate_image);
            copy($this->certificate_image,$newName);
            $clone->certificate_image = $newName;
        }

        foreach ($this->courseCategories as $category){
            $clone->courseCategories()->attach($category->id);
        }

        foreach ($this->tests as $test){
            $clone->tests()->attach($test->id);
        }

        foreach ($this->lessons as $lesson){
           $lessonClone = $clone->lessons()->create($lesson->toArray());
           foreach ($lesson->lectures as $lecture){
               $lectureClone = $lessonClone->lectures()->create($lecture->toArray());
               foreach($lecture->lecturePages as $lecturePage){
                  $lectureClone->lecturePages()->create($lecturePage->toArray());
               }
               foreach($lecture->lectureFiles as $lectureFile){
                   $lectureFileData = $lectureFile->toArray();
                   //copy file
                   $lectureFileData['path'] = copyCourseFile($lectureFile->path);
                   $lectureClone->lectureFiles()->create($lectureFileData);
               }
           }
        }

        foreach ($this->courseInstructors as $courseInstructor){
            $clone->courseInstructors()->attach($courseInstructor->id);
        }

        foreach ($this->courseFiles as $courseFile){
            $courseFileData = $courseFile->toArray();
            //copy file
            $courseFileData['path'] = copyCourseFile($courseFile->path);
            $clone->courseFiles()->create($courseFileData);
        }

        $clone->save();
    }

    public function scopeOpenCourses($query){
        $query->where('enabled',1);
        $query->where(function($query){
            $query->whereNull('end_date')
                ->orWhere('end_date', '>=', now()->toDateString());
        });
        $query->where(function($query){
            $query->whereNull('closes_on')
                ->orWhere('closes_on', '>=', now()->toDateString());
        });
        return $query;
    }

    public function scopePublicCourses($query){
        return $query->where('all_users',1);
    }

    public function scopeOrdered($query){
        return $query->orderBy('pinned','desc')->latest();
    }



    public function departments(){
        return $this->belongsToMany(Department::class);
    }

}
