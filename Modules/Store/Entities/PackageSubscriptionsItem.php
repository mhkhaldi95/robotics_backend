<?php

namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Student;

class PackageSubscriptionsItem extends Model
{
    protected $fillable = [];

    public function item(){
        return $this->morphOne(Item::class,'details');
    }

    public function subscribedKeyStudent(){
        return $this->students->where('pivot.expired',null)->pluck('id')->toArray();
    }

    public function students(){
        return $this->belongsToMany(Student::class,'package_subscriptions','package_subscriptions_item_id','student_id')->withPivot(['started_at','expiration_at','expired']);
    }


    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

}
