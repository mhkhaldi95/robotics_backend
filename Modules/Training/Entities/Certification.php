<?php

namespace Modules\Training\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = ['course_id','student_id','content'];

    static $rules = [
        'content'=> 'required',
    ];

    static $messages = [
        'content.required'=>'Content of certification as Null !!',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

}
