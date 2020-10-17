<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identifier extends Model
{
    public function document(){
        return $this->morphOne(Document::class,'documentable');
    }
}
