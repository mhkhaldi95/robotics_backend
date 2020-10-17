<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
    protected $fillable = ['schedule_id','name','content','start','finish'];

    static $rules = [
        'name'=> 'required',
        'content'=> 'required',
    ];

    static $messages = [
        'name.required'=>'Name of context as Null !!',
        'content.required'=>'Content of context as Null !!',
    ];

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
}
