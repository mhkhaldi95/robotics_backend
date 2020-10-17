<?php

namespace Modules\Store\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Order extends Item
{
    protected $guarded = [];

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
