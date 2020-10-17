<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['dsec_url'];
    public function user()
    {
        return $this->morphTo('user');
    }
    public function identifier()
    {
        return $this->morphTo( 'documentable');
    }
}
