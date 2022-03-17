<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type)
    {
//        dd(auth()->user()->type);
        if (User::TYPE_SLUGS[auth()->user()->type] !== $type) {
            abort(404);
//            dd('You are buyer');
        }
//        dd('You are seller');
        return $next($request);
    }
}
