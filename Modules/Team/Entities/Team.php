<?php

namespace Modules\Team\Entities;

use App\Image;
use App\Student;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['leader_id','name','description'];

    static $rules = [
        'name'=> 'required|unique:teams,name',
        'description'=> 'required',
        'image' => 'mimes:jpeg,jpg,png|max:10000',
    ];

    static $messages = [
        'name.required'=>'Name of team as Null !!',
        'name.unique' => 'Name of team must be unique',
        'description.required'=>'Descriptipn of team as Null !!',
    ];
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
    public function leader(){
        return $this->belongsTo(Student::class,'leader_id','id');
    }

    public function project(){
        return $this->hasOne(Project::class);
    }

    public function students(){
        return $this->morphToMany(Student::class,'ticketable','tickets')->withPivot('withdraw_at');
    }

    public function invitations(){
        return $this->belongsToMany(Student::class,'invitations','team_id','id')->withPivot(['from_student_id','to_student_id','approved_at']);
    }

    public function joinRequests(){
        return $this->hasMany(JoinRequest::class,'to_team_id','id');
    }
    protected $appends=['image_path'];

    public function getImagePathAttribute(){
        return asset('/uploads/image_team/'.$this->image->dsec_url);
    }
}
