<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $guarded = [];
    public function group(){
        return $this->belongsTo(Group::class);
    }
}
