<?php

namespace Modules\Competition\Entities;

use App\Admin;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = ['name','description'];

    static $rules = [
        'name'=> 'required',
        'description'=> 'required',
    ];

    static $messages = [
        'name.required'=>'Name of competition as Null !!',
        'description.required'=>'Description of competition as Null !!',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
