<?php

namespace Modules\Team\Entities;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['team_id','to_student_id','from_student_id'];
}
