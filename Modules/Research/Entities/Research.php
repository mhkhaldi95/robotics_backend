<?php

namespace Modules\Research\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $fillable = ['name','description'];
    protected $table = 'researches';

    static $rules = [
        'name'=> 'required',
        'description'=> 'required',
    ];

    static $messages = [
        'name.required'=>'Name of research as Null !!',
        'description.required'=>'Descriptipn of research as Null !!',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
