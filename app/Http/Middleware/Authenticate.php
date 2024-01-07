<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $unauthorized = [
            'error' => 'You are not authorized for this route.',
            'success' => false,
        ];

        $unauthorizedResponse = response()->json($unauthorized, Response::HTTP_UNAUTHORIZED);
        return $request->expectsJson() ? $unauthorizedResponse : null;
    }
}
