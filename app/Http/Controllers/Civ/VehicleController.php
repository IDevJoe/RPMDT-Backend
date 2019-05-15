<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Http\Controllers\Civ;


use App\CannedResponse;
use App\Character;
use App\Events\Civ\VehicleCreateEvent;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createVehicle(Request $request, $cid) {
        $c = Character::find($cid);
        if($c == null) return CannedResponse::NotFound();
        if($c->user->id !== Auth::user()->id) return CannedResponse::Fortbidden();
        $this->validate($request, [
            'make' => 'required|string',
            'model' => 'required|string',
            'color' => 'required|string',
            'plate' => 'required|string'
        ]);
        $veh = Vehicle::create(['make' => $request->json('make'), 'model' => $request->json('model'),
            'color' => $request->json('color'), 'character_id' => $c->id, 'plate' => $request->json('plate')]);
        event(new VehicleCreateEvent($veh));
        return CannedResponse::Created($veh);
    }

}