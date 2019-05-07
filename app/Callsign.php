<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Callsign extends Model
{

    public const TYPE_POLICE = 0;
    public const TYPE_FIRE = 0;

    protected $fillable = ['user_id', 'callsign', 'type'];

    public function user() {
        return $this->belongsTo('App\User');
    }

}