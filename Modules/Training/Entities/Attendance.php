<?php

namespace Modules\Training\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['lesson_id','student_id'];

    public function lesson(){
        $this->belongsTo(Lesson::class);
    }

    public function student(){
        $this->belongsTo(Student::class);
    }
}
