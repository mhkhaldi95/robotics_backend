<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\News\Entities\Post;

class Category extends Model
{
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
