<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['exam_id','content','course_id'];

    static $rules = [
        'content'=> 'required',
    ];

    static $messages = [
        'content.required'=>'Contnet of question as Null !!',
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function answer(){
        return $this->hasOne(Answer::class);
    }
    public function choices(){
        return $this->hasMany(Choice::class);
    }
}
