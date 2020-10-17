<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['course_id','start','finish','student_id'];

    static $rules = [
        'start'=> 'required',
        'finish'=> 'required',
    ];

    static $messages = [
        'start.required'=>'Start date of exam as Null !!',
        'finish.required'=>'Start date of exam as Null !!',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
