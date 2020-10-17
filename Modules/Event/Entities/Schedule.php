<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['event_id','description'];

    static $rules = [
        'description'=> 'required',
    ];

    static $messages = [
        'description.required'=>'Description of schedule as Null !!',
    ];

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function contexts(){
        return $this->hasMany(Context::class);
    }
}
