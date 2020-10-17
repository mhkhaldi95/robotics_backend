<?php

namespace Modules\Store\Entities;

use App\Organizer;
use Illuminate\Database\Eloquent\Model;

class TicketItem extends Item
{
    protected $guarded = [];
    public function details(){
        return $this->morphOne(Item::class,"details");
    }
    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }
    public function ticketable(){
        return $this->morphTo();
    }
}
