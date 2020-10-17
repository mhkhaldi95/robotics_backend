<?php

namespace Modules\Team\Entities;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $fillable = ['to_team_id','from_student_id'];

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
