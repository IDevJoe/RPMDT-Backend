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

    protected $fillable = ['call_id', 'type', 'message'];
    protected $table = "calllog";

    public const TYPE_CALL_UPDATE = "TYPE_CALL_UPDATE";
    public const TYPE_CALL_ASSIGN = "TYPE_CALL_ASSIGN";
    public const TYPE_CALL_DETACH = "TYPE_CALL_DETACH";
    public const TYPE_CALL_ARCHIVE = "TYPE_CALL_ARCHIVE";
    public const TYPE_UNIT_STATUSCHANGE = "TYPE_UNIT_STATUSCHANGE";

    public function call() {
        return $this->belongsTo('App\Call');
    }

    protected $dispatchesEvents = [
        'created' => 'App\Events\Universal\CallLogEvent'
    ];
}