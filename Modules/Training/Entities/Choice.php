<?php

namespace Modules\Training\Entities;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = ['content'];
    public function quastion(){
        return $this->belongsTo(Answer::class);
    }
}
