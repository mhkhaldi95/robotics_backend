<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['course_id','name'];

    static $rules = [
        'name'=> 'required',
    ];

    static $messages = [
        'name.required'=>'Name of section as Null !!',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
}
