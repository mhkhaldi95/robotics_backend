<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Modules\Store\Entities\ExpireBaqa;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    protected $fillable = ['name','display_name','description'];

    public function packages(){
        return $this->belongsToMany(Package::class,'permission_packages');
    }

}
