<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'person_password'
//    ];
    
    protected $connection = 'person';

    protected $table = 'personal';

    protected $primaryKey = 'person_id';

    protected $keyType = 'string';

    /** For JWT auth */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /** Relational */
    public function ward()
    {
        return $this->belongsTo('App\Models\Ward', 'office_id', 'ward_id');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position', 'position_id', 'position_id');
    }

    public function academic()
    {
        return $this->belongsTo('App\Models\Academic', 'ac_id', 'ac_id');
    }

    // public function driver()
    // {
    //     return $this->hasOne('App\Models\Driver', 'person_id', 'person_id');
    // }

    // public function maintained()
    // {
    //     return $this->hasMany('App\Maintenance', 'staff', 'person_id');
    // }

    // public function reservation()
    // {
    //     return $this->hasMany('App\Reservation', 'user_id', 'person_id');
    // }

    // public function passenger()
    // {
    //     return $this->hasMany('App\ReservePassenger', 'person_id', 'person_id');
    // }
}
