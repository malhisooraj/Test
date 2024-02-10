<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }
        // We don't need this as we have added this login in AppServiceProvider boot method
        if (auth()->user()->username !== 'Soorajmalhi') {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
