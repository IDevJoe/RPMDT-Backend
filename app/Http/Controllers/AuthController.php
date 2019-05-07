<?php

namespace App\Http\Controllers;

use App\CannedResponse;
use App\Token;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
}
