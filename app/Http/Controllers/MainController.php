<?php

namespace App\Http\Controllers;

use App\CannedResponse;
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
        return CannedResponse::OK(Auth::user());
    }
}
