<?php

namespace Modules\Event\Entities;

use App\Organizer;
use App\Ticket;
use Illuminate\Database\Eloquent\Model;
use Modules\Store\Entities\Item;
use Modules\Store\Entities\TicketItem;

class Event extends Model
{
    protected $fillable = ['name','description','organizer_id','approved_at'];

    static $rules = [
        'name'=> 'required',
        'description'=> 'required',
    ];

    static $messages = [
        'name.required'=>'Name of event as Null !!',
        'description.required'=>'Description of event as Null !!',
    ];

    public function schedule(){
        return $this->hasOne(Schedule::class);
    }

    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }

    public function item(){
        return $this->morphOne(Item::class,'details');
    }

    public function tickets(){
        return $this->morphMany(Ticket::class,"ticketable");
    }
}
