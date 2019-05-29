<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Call extends Model
{
    use SoftDeletes;

    public const CALL_POLICE = 0;
    public const CALL_FIRE = 1;

    protected $fillable = ['primary_id', 'type', 'summary', 'description', 'code'];
    protected $with = ['primary', 'units'];

    public function primary() {
        return $this->belongsTo('App\User', 'primary_id')->without('activecall')->without('callsigns')
            ->without('characters');
    }

    public function units() {
        return $this->hasMany('App\User')->without('activecall')->without('callsigns')
            ->without('characters');
    }

    public function log() {
        return $this->hasMany('App\CallLog')->limit(10);
    }
}