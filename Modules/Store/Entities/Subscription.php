<?php

namespace Modules\Store\Entities;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['type'];
    protected $table = 'subscriptionns';

    public function packages(){
        return $this->belongsToMany(Package::class,'package_subscriptions_items');
    }

    public function packageSubscriptionItem (){
        return $this->hasOne(PackageSubscriptionsItem::class);
    }
}
