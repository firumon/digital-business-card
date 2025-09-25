<?php

namespace Firumon\DigitalBusinessCard\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$Roles): Response
    {
        return in_array($request->user()->role,$Roles) ? $next($request) : response(['Unauthorized'],401);
    }
}
