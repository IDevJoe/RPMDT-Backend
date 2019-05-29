<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = ['user_id', 'lname', 'mname', 'fname', 'eye_color',
        'street_addr', 'city', 'state', 'lstatus', 'dob'];
    protected $with = ['user', 'warrants'];

    public function user() {
        return $this->belongsTo('App\User')->without('characters');
    }

    public function warrants() {
        return $this->hasMany('App\Warrant');
    }

    public function vehicles() {
        return $this->hasMany('App\Vehicle')->without('character');
    }
}