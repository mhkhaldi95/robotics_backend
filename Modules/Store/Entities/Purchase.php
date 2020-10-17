<?php

namespace Modules\Store\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
