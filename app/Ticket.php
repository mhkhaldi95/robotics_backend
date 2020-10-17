<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Training\Entities\Course;

class Ticket extends Model
{
    protected $guarded = [];

    public function course(){
        return $this->morphTo("ticketable");
    }

    public function students(){
        return $this->morphedByMany(Student::class,'ticketable','tickets');
    }
}
