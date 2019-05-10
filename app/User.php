<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'callsign_id', 'call_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email'
    ];

    protected $with = ['callsigns', 'currentCallsign', 'activecall', 'characters'];

    public function callsigns() {
        return $this->hasMany('App\Callsign');
    }

    public function currentCallsign() {
        return $this->belongsTo('App\Callsign', 'callsign_id');
    }

    public function tokens() {
        return $this->hasMany('App\Token');
    }

    public function newToken() {
        $t = Token::create(['token' => bin2hex(random_bytes(15)), 'user_id' => $this->id, 'expires_at' => Carbon::now()->addDay()]);
        return $t;
    }

    public function activecall() {
        return $this->belongsTo('App\Call', 'call_id')->without('units')->without('primary');
    }

    public function characters() {
        return $this->hasMany('App\Character')->without('user');
    }
}
