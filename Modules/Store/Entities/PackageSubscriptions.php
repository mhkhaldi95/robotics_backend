<?php

namespace Modules\Store\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class PackageSubscriptions extends Model
{
    protected $fillable = ['expired'];
    protected $table = 'package_subscriptions';
}
