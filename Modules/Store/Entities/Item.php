<?php

namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Training\Entities\Course;

class Item extends Model
{
    protected $guarded = [];

    public function details(){
        return $this->morphTo('details');
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }

}
