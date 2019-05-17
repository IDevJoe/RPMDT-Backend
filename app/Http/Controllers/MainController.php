<?php

namespace App\Http\Controllers;

use App\CannedResponse;
use App\User;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile() {
        $user = Auth::user();
        $u = User::with('callsigns')->with('characters')->where('id', $user->id)->first();
        return CannedResponse::OK($u);
    }
}
