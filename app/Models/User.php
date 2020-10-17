<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Laratrust\Traits\LaratrustUserTrait;

class User extends LaratrustPermission
{
    use LaratrustUserTrait;
    public $guarded = [];
}
