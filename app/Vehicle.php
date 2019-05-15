<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $fillable = ['make', 'model', 'color', 'plate', 'character_id'];
    protected $hidden = ['character_id'];
    protected $with = ['character'];

    public function character() {
        return $this->belongsTo('App\Character')->without('vehicles');
    }

}