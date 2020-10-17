<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable =['dsec_url'];
    public function user(){
        return $this->morphTo();
    }
}
