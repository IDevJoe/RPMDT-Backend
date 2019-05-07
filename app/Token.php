<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    protected $fillable = ['user_id', 'token', 'expires_at'];
    protected $hidden = ['token'];
    protected $with = ['user'];

    public function user() {
        return $this->belongsTo('App\User');
    }

}