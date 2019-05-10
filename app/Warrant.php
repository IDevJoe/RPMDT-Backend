<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Warrant extends Model
{

    protected $fillable = ['character_id', 'type', 'info'];

    public function character() {
        return $this->belongsTo('App\Character');
    }

}