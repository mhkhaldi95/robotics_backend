<?php

namespace Modules\Store\Entities;

use App\Trainer;
use Illuminate\Database\Eloquent\Model;
use Modules\Training\Entities\Course;

class CourseItem extends Item
{
    protected $guarded = [];
    public function details(){
        return $this->morphOne(Item::class,"details");
    }
    public function trainer(){
        return $this->belongsTo(Trainer::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
}
