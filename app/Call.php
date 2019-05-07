<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Call extends Model
{

    public const CALL_POLICE = 0;
    public const CALL_FIRE = 1;

    protected $fillable = ['primary_id', 'type', 'summary', 'description', 'code'];
    protected $with = ['primary', 'units'];

    public function primary() {
        return $this->belongsTo('App\User', 'primary_id')->without('activeCall')->without('callsigns');
    }

    public function units() {
        return $this->hasMany('App\User')->without('activeCall')->without('callsigns');
    }
}