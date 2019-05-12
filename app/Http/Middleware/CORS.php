<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class CORS
{

    private function attachHeaders($r) {
        if(!($r instanceof Response))
            $r = \response($r);
        return $r->header('Access-Control-Allow-Origin', App::environment() == 'production' ? env('MDT_URL', 'http://localhost') : '*')
            ->header('Access-Control-Allow-Headers', "Content-Type, Authorization")
            ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->method() == "OPTIONS") {
            return $this->attachHeaders(response(null, 204));
        }
        return $this->attachHeaders($next($request));
    }
}
