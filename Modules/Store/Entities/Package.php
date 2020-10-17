<?php

namespace Modules\Store\Entities;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasTranslations;
    public $translatable = ['name','description'];

    protected $fillable = ['name','description'];
    static $rules = [

        'name.ar'=> 'required|unique:packages,name->ar',
        'name.en'=> 'required|unique:packages,name->en',
        'description.ar'=> 'required',
        'description.en'=> 'required',
        'price.month'=> 'required',
        'price.year'=> 'required',
    ];

    static $messages = [
        'name.required'=>'Name of team as Null !!',
        'name.unique' => 'Name of team must be unique',
    ];

//    public function item(){
//        return $this->morphOne(Item::class,'details');
//    }

    public function subscriptions(){
        return $this->belongsToMany(Subscription::class,'package_subscriptions_items');
    }

    public function terms(){
        return $this->belongsToMany(Term::class,'term_packages');
    }



}
