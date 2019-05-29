<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Http\Controllers\Gameplay\Universal;


use App\CannedResponse;
use App\Character;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Laravel\Lumen\Http\Request;

class UniversalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lookupId(Request $request) {
        return CannedResponse::OK(Character::where('lname', 'like', $request->json('lname'))->limit(10)->without('user')->with('vehicles')->get());
    }

    public function plate($plate) {
        $plate = Vehicle::where('plate', $plate)->first();
        if($plate == null) return CannedResponse::NotFound();
        return CannedResponse::OK($plate);
    }

}