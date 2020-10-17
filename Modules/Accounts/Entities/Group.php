<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function fields(){
        return $this->hasMany(Field::class);
    }
}
