<?php

namespace Modules\Training\Entities;

use App\Student;
use App\Ticket;
use App\Trainer;
use Illuminate\Database\Eloquent\Model;
use Modules\Store\Entities\Item;

class Course extends Model
{
    protected $fillable = ['name','description','trainer_id','hours'];

    static $rules = [
        'name'=> 'required',
        'description'=> 'required',
        'hours'=> 'required|numeric',
        'price'=> 'required|numeric'
    ];

    static $messages = [
        'name.required'=>'Name of course as Null !!',
        'description.required'=>'Description of course as Null !!',
        'hours.required'=>'Hours of course as Null !!',
        'hours.numeric'=>'Hours must be number',
        'price.required'=>'Price of course as Null !!',
        'price.numeric'=>'Price must be number',
    ];

    public function trainer(){
        return $this->belongsTo(Trainer::class);
    }

    public function ownerKey(){
        return $this->trainer->id;
    }

    public function registeredKeyStudent(){

        return $this->students->pluck('id')->toArray();
    }

    public function sections(){
        return $this->hasMany(Section::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    public function exam(){
        return $this->hasOne(Exam::class);
    }
    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function assignments(){
        return $this->hasMany(Assignment::class);
    }

    public function certifications(){
        return $this->hasMany(Certification::class);
    }

    public function evaluations(){
        return $this->hasMany(Evaluation::class);
    }

    public function item(){
        return $this->morphOne(Item::class,'details');
    }

    public function students(){
        return $this->morphToMany(Student::class,'ticketable','tickets')->withPivot('withdraw_at');

    }

    public function ticket(){
        return  $this->morphOne(Ticket::class,'ticketable');
    }
    public function getEvaluationAttribute(){
        $count = count($this->evaluations);
        $sumEvaluation = $this->evaluations->sum('value');
        return ($sumEvaluation/$count);
    }

    public function getCountAttribute(){
        $counterLesson = 0;
        foreach($this->sections as $section){
            $counterLesson +=  $section->lessons->count();
        }
        return $counterLesson;
    }

}
