<?php

namespace App\Http\Middleware;

use Closure;

class ForceJsonMiddleware
{
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');
        $response = $next($request);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
