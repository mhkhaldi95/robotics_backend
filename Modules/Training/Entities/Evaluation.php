<?php

namespace Modules\Training\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['course_id','student_id','value'];

    static $rules = [
        'value'=> 'required',
    ];

    static $messages = [
        'value.required'=>'Value of evaluation as Null !!',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
