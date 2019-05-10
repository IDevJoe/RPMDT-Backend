<?php

namespace App\Http\Controllers;

use App\CannedResponse;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Pusher\Pusher;
use Pusher\PusherInstance;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function authorizeU(Request $request) {
        if(!$request->has('email')) return CannedResponse::BadRequest();
        if(!$request->has('password')) return CannedResponse::BadRequest();
        $user = User::where('email', $request->get('email'))->first();
        if($user == null) return CannedResponse::Unauthorized();
        if(!Hash::check($request->get('password'), $user->password)) return CannedResponse::Unauthorized();
        $t = $user->newToken();
        $t = Token::find($t->id);
        $t->makeVisible(['token']);
        return CannedResponse::OK($t);
    }

    private static function authorizeChannel($socket, $channel) {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), ['cluster' => env('PUSHER_APP_CLUSTER')]);
        $auth =  json_decode($pusher->socket_auth($channel, $socket));
        return ['auth' => $auth->auth];
    }

    public function authorizePrivateChannel(Request $request) {
        $this->validate($request, [
            'socket_id' => 'required|string',
            'channel_name' => 'required|string'
        ]);
        $socket = $request->get('socket_id');
        $channel = $request->get('channel_name');
        switch($channel) {
            case ('private-user.' . Auth::user()->id):
                return self::authorizeChannel($socket, $channel);
                break;
            case 'private-police.calls':
                return self::authorizeChannel($socket, $channel);
                break;
            default:
                return CannedResponse::Fortbidden();
        }
    }
}
