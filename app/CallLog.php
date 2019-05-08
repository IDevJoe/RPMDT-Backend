<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{

    protected $fillable = ['call_id', 'message'];
    protected $table = "calllog";

    public function call() {
        return $this->belongsTo('App\Call');
    }

    protected $dispatchesEvents = [
        'created' => 'App\Events\Universal\CallLogEvent'
    ];
}