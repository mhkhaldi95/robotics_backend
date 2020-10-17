<?php

namespace Modules\News\Entities;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','content','approved_at'];

    static $rules = [
        'title'=> 'required',
        'content'=> 'required',
    ];

    static $messages = [
        'title.required'=>'Title of post as Null !!',
        'content.required'=>'Content of post as Null !!',
    ];

    public function user(){
        return $this->morphTo(User::class,"user");
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
