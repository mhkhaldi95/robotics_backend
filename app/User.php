<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Cashier\Billable;
use Modules\Accounts\Entities\Profile;
use Modules\News\Entities\NewPaper;
use Modules\Research\Entities\Research;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laratrust\Models\LaratrustPermission;
use Laratrust\Traits\LaratrustUserTrait;
use Modules\News\Entities\Post;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use LaratrustUserTrait;
    use Billable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function profile(){
        return $this->morphOne(Profile::class,"profileable");
    }

    public function document(){
        return $this->morphOne(Document::class,"user");
    }
    public function identifier()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    public function researches(){
       return $this->hasMany(Research::class);
    }

    public function posts(){
        return $this->morphMany(Post::class,"user");
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function owns($resource){
        return $resource->ownerKey() === $this->id;
    }

    public function subscribedCourse($resource){

        return in_array($this->id,$resource->registeredKeyStudent()) ;
    }


    public function subscribedPackage($resource){
        return in_array($this->id,$resource->subscribedKeyStudent()) ;
    }

}
