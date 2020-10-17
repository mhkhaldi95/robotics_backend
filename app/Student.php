<?php

namespace App;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Modules\Store\Entities\Baqa;
use Modules\Store\Entities\ExpireBaqa;
use Modules\Store\Entities\Order;
use Modules\Store\Entities\PackageSubscriptions;
use Modules\Store\Entities\PackageSubscriptionsItem;
use Modules\Store\Entities\Purchase;
use Modules\Store\Entities\Subscription;
use Modules\Store\Entities\Term;
use Modules\Team\Entities\Invitation;
use Modules\Team\Entities\JoinRequest;
use Modules\Team\Entities\Team;
use Modules\Training\Entities\Attendance;
use Modules\Training\Entities\Certification;
use Modules\Training\Entities\Course;
use Modules\Training\Entities\Evaluation;

class Student extends User
{
    //
    protected $guarded =[];
    protected $fillable = ['user_name','first_name','second_name','last_name','age','email','password'];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    static  $rule = [
                'first_name' => 'required|string|max:255',
                'second_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'user_name' => 'required|string|max:255|unique:students,user_name|unique:fathers,user_name|
                                            |unique:trainers,user_name|unique:owners,user_name|unique:organizers,user_name|
                                            |unique:sellers,user_name|unique:admins,user_name',
                'email' => 'required|string|max:255|unique:students,email|unique:fathers,email|
                                            |unique:trainers,email|unique:owners,email|unique:organizers,email|
                                            |unique:sellers,email|unique:admins,email',
                'password' => 'required|string|max:255',
                'age'=>'required|numeric',
                'image' => 'mimes:jpeg,jpg,png|max:10000',
                'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'
                ];
    static  $messages = [
                'first_name.required'=>'First name is required',
                'first_name.string'=>'First name must be string',
                'first_name.max'=>'First name must be long',

                'second_name.required'=>'Seconde name is required',
                'second_name.string'=>'Seconde name must be string',
                'second_name.max'=>'Seconde name must be long',

                'last_name.required'=>'Last name is required',
                'last_name.string'=>'Last name must be string',
                'last_name.max'=>'Last name must be long',

                'user_name.required'=>'User name is required',
                'user_name.string'=>'User name must be string',
                'user_name.max'=>'User name must be long',
                'user_name.unique'=>'User name must be unique',

                'email.required'=>'Email is required',
                'email.email'=>'Email must be email',
                'email.string'=>'Email must be string',
                'email.max'=>'Email must be long',
                'email.unique'=>'Email must be unique',

                'password.required'=>'Password is required',
                'password.string'=>'Password must be string',
                'password.max'=>'Password must be long',
                'password.confirmed'=>'Password must be confirmed',

                'age.numeric'=>'Age must be numeric',
                'age.required'=>'Age must is required',

                ];


    public function father(){
        return $this->belongsTo(Father::class);
    }

// ----------------------------- COURSE -----------------------------
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }

    public function courses(){
        return $this->morphedByMany(Course::class,'ticketable','tickets')->withPivot('withdraw_at');

    }

    public function certifications(){
        return $this->hasMany(Certification::class);
    }

    public function evaluations(){
        return $this->hasMany(Evaluation::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

// ----------------------------- TEAM -----------------------------

    // student is leader
    public function leaded_teams(){
        return $this->hasMany(Team::class,'leader_id','id');
    }

    public function teams(){
        return $this->morphedByMany(Team::class,'ticketable','tickets')->withPivot('withdraw_at');
    }

    public function invitations(){
        return $this->belongsToMany(Team::class,'invitations','to_student_id','id')->withPivot(['team_id','from_student_id','approved_at']);
    }

    public function joinRequests(){
        return $this->belongsToMany(Student::class,'join_requests','from_student_id','id')->withPivot(['to_team_id','approved_at']);
    }

// ----------------------------- STORE -----------------------------

    // store
    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function packageSubscriptions(){
        return $this->belongsToMany(PackageSubscriptionsItem::class,'package_subscriptions','student_id','package_subscriptions_item_id')->withPivot(['started_at','expiration_at','expired']);
    }

    public function terms(){
        return $this->belongsToMany(Term::class,'term_students')->withPivot(['package_subscriptions_item_id']);
    }

    public function hasTerm($term){

        return in_array($term,$this->terms->pluck('name')->toArray()) ;
    }
//      protected $appends=['image_path'];
//
//      public function getImagePathAttribute(){
//          return asset('/uploads/image_user/students/'.$this->image->dsec_url);
//      }





}
