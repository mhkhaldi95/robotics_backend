<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Competition\Entities\Competition;

class Admin extends User
{
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
        'image' => 'mimes:jpeg,jpg,png|max:10000',
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
    protected $guarded =[];
    protected $fillable=['user_name','first_name','second_name','last_name','password','email'];

    public function competitions(){
        return $this->hasMany(Competition::class);
    }

}
