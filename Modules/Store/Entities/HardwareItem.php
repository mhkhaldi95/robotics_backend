<?php

namespace Modules\Store\Entities;

use App\Seller;
use Illuminate\Database\Eloquent\Model;

class HardwareItem extends Item
{
    protected $guarded = [];
    public function details(){
        return $this->morphOne(Item::class,"details");
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
}
