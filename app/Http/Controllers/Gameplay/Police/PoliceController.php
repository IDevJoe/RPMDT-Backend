<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Http\Controllers\Gameplay\Police;


use App\Call;
use App\Callsign;
use App\CannedResponse;
use App\Events\Police\CallsignChangeEvent;
use App\Events\Police\StatusChangeEvent;
use App\Events\Universal\UnitDetachEvent;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Request;

class PoliceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function state() {
        return CannedResponse::OK(['police' => User::where('status', '!=', null)->get()->makeHidden('email'), 'calls' => Call::get(), 'active_call' => Auth::user()->activecall,
            'status' => Auth::user()->status, 'callsign' => Auth::user()->currentCallsign]);
    }

    public function setCallsign(Request $request) {
        if(!$request->json('callsign')) return CannedResponse::BadRequest();
        $callsign = Callsign::where('id', $request->json('callsign'))->where('user_id', Auth::user()->id)->first();
        if($callsign == null) return CannedResponse::BadRequest();
        event(new CallsignChangeEvent(Auth::user(), $callsign));
        return CannedResponse::NoContent();
    }

    public function setStatus(Request $request) {
        $user = Auth::user();
        event(new StatusChangeEvent($user, $request->json('status')));
        return CannedResponse::NoContent();
    }

    public function detach() {
        event(new UnitDetachEvent(Auth::user()));
        return CannedResponse::NoContent();
    }
}