<?php


namespace App\Http\Controllers\Gameplay\Dispatch;


use App\CannedResponse;
use App\Events\Police\StatusChangeEvent;
use App\Http\Controllers\Controller;
use App\User;
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

}