<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id','content'];

    static $rules = [
        'content'=> 'required',
    ];

    static $messages = [
        'content.required'=>'Content of answer as Null !!',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
