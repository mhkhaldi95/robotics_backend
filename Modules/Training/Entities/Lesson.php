<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['section_id','title','content'];

    static $rules = [
        'title'=> 'required',
        'content'=> 'required',
    ];

    static $messages = [
        'title.required'=>'Title of lesson as Null !!',
        'content.required'=>'Content of lesson as Null !!',
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }
}
