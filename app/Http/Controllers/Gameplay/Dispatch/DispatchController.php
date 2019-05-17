<?php


namespace App\Http\Controllers\Gameplay\Dispatch;


use App\Call;
use App\CallLog;
use App\CannedResponse;
use App\Events\Police\StatusChangeEvent;
use App\Events\Universal\CallArchiveEvent;
use App\Events\Universal\CallAssignEvent;
use App\Events\Universal\CallUpdateEvent;
use App\Events\Universal\UnitDetachEvent;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Request;

class DispatchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setStatus(Request $request, $user) {
        $user = User::find($user);
        if($user == null) return CannedResponse::BadRequest();
        event(new StatusChangeEvent($user, $request->json('status')));
        return CannedResponse::NoContent();
    }

    public static function newCall(Request $request) {
        $primary = $request->json('primary_id');
        $type = Call::CALL_POLICE;
        $summary = $request->json('summary');
        $description = $request->json('description');
        $code = $request->json('code');
        if(!$description) $description = "NO FURTHER INFORMATION";
        if(!$primary || !$summary || !$description || !$code) return CannedResponse::BadRequest();
        $call = Call::create(['primary_id' => $primary, 'type' => $type, 'summary' => $summary,
            'description' => $description, 'code' => $code]);
        $call = Call::find($call->id);
        CallLog::create(['call_id' => $call->id, 'message' => 'Call created by ' . Auth::user()->name, 'type' => CallLog::TYPE_CALL_CREATE]);
        event(new \App\Events\Universal\CallUpdateEvent($call));
        event(new CallAssignEvent($call, User::find($primary)));
        return CannedResponse::Created($call);
    }

    public static function assignCall($unit, $call) {
        $user = User::find($unit);
        $call = Call::find($call);
        if($user == null || $call == null) return CannedResponse::BadRequest();
        event(new CallAssignEvent($call, $user));
        return CannedResponse::NoContent();
    }

    public static function detach($unit) {
        $user = User::find($unit)->without('callsigns')->without('characters');
        if($user == null) return CannedResponse::NotFound();
        event(new UnitDetachEvent($user));
        return CannedResponse::NoContent();
    }

    public static function archiveCall($call) {
        $call = Call::find($call);
        if($call == null) return CannedResponse::NotFound();
        event(new CallArchiveEvent($call));
        return CannedResponse::NoContent();
    }

    public static function updateCall(Request $request, $call) {
        $call = Call::find($call);
        if($call == null) return CannedResponse::NotFound();
        if($request->json('code')) $call->code = $request->json('code');
        if($request->json('summary')) $call->summary = $request->json('summary');
        if($request->json('description')) $call->description = $request->json('description');
        $call->save();
        event(new CallUpdateEvent($call));
        return CannedResponse::NoContent();
    }

}