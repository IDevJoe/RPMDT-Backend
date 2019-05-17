<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Http\Controllers\Civ;


use App\CannedResponse;
use App\Character;
use App\Events\Civ\VehicleCreateEvent;
use App\Events\Civ\VehicleDeleteEvent;
use App\Events\Civ\VehicleUpdateEvent;
use App\HF;
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
            'plate' => 'required|string',
            'plstatus' => 'required|string',
            'instatus' => 'required|string'
        ]);
        $veh = Vehicle::create(['make' => $request->json('make'), 'model' => $request->json('model'),
            'color' => $request->json('color'), 'character_id' => $c->id, 'plate' => $request->json('plate')]);
        event(new VehicleCreateEvent($veh));
        return CannedResponse::Created($veh);
    }

    public function editVehicle(Request $r, $vehicle) {
        $vehicle = Vehicle::find($vehicle);
        if($vehicle == null) return CannedResponse::NotFound();
        if($vehicle->character->user->id != Auth::user()->id) return CannedResponse::Fortbidden();
        HF::updateModel(['make', 'model', 'color', 'plate', 'plstatus', 'instatus'], $vehicle, $r);
        event(new VehicleUpdateEvent($vehicle));
        return CannedResponse::NoContent();
    }

    public function delVehicle(Request $r, $vehicle) {
        $vehicle = Vehicle::find($vehicle);
        if($vehicle == null) return CannedResponse::NotFound();
        if($vehicle->character->user->id != Auth::user()->id) return CannedResponse::Fortbidden();
        event(new VehicleDeleteEvent($vehicle));
        return CannedResponse::NoContent();
    }

}