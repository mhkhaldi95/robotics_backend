<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['course_id','content'];

    static $rules = [
        'content'=> 'required',
    ];

    static $messages = [
        'content.required'=>'Contnet of assignment as Null !!',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function submission(){
        return $this->hasOne(Submission::class);
    }
}
