<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PsychologistMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!$request->user()->hasRole(['Psychologist', 'Counselor'])) {
            abort(403, 'Unauthorized access. Psychologist/Counselor only.');
        }

        return $next($request);
    }
}