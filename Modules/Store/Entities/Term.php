<?php

namespace Modules\Store\Entities;

use App\Student;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Term extends Model
{
    use HasTranslations;
    public $translatable = ['name'];
    protected $fillable = [];
    protected $guarded = [];
    public function packages(){
        return $this->belongsToMany(Package::class,'term_packages');
    }
    public function students(){
        return $this->belongsToMany(Student::class,'term_students');
    }
}
