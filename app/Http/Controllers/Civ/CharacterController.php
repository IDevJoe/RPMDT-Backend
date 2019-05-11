<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Http\Controllers\Civ;


use App\CannedResponse;
use App\Character;
use App\Events\Civ\CharacterDeleteEvent;
use App\Events\Civ\NewCharacterEvent;
use App\Http\Controllers\Controller;
use App\Warrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newCharacter(Request $request) {
        $this->validate($request, [
            'lname' => 'required|string',
            'mname' => 'required|string',
            'fname' => 'required|string',
            'eye_color' => 'required|string',
            'street_addr' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'lstatus' => 'required|string',
            'warrants' => 'array',
            'dob' => 'required|date'
        ]);
        $c = Character::create(['user_id' => Auth::user()->id,
            'lname' => $request->json('lname'),
            'mname' => $request->json('mname'),
            'fname' => $request->json('fname'),
            'eye_color' => $request->json('eye_color'),
            'street_addr' => $request->json('street_addr'),
            'city' => $request->json('city'),
            'state' => $request->json('state'),
            'lstatus' => $request->json('lstatus'),
            'dob' => $request->json('dob')]);

        if($request->json('warrants'))
            foreach($request->json('warrants') as $w) {
                if($w['type'] == null) continue;
                if($w['info'] == null) continue;
                Warrant::create(['character_id' => $c->id, 'type' => $w['type'], 'info' => $w['info']]);
            }
        event(new NewCharacterEvent(Character::find($c->id)));
        return CannedResponse::Created(Character::find($c->id));

    }

    public function delCharacter($id) {
        $char = Character::find($id);
        if($char == null) return CannedResponse::NotFound();
        if($char->user->id != Auth::user()->id) return CannedResponse::Fortbidden();
        event(new CharacterDeleteEvent($char));
        return CannedResponse::NoContent();
    }
}