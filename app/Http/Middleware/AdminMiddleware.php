<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Api;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty(auth()->guard('api')->user()) || auth()->guard('api')->user()->role != "Admin") {
            return Api::apiRespond(401, []);
        }

        return $next($request);
    }
}
