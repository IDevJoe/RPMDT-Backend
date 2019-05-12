<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Http\Controllers\Gameplay\Universal;


use App\CannedResponse;
use App\Character;
use App\Http\Controllers\Controller;
use Laravel\Lumen\Http\Request;

class UniversalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lookupId(Request $request) {
        return CannedResponse::OK(Character::where('lname', 'like', $request->json('lname'))->limit(10)->without('user')->get());
    }

}