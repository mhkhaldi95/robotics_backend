<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['assignment_id','content'];

    static $rules = [
        'content'=> 'required',
    ];

    static $messages = [
        'content.required'=>'Contnet of submission as Null !!',
    ];

    public function assignment(){
        return $this->belongsTo(Assignment::class);
    }
}
