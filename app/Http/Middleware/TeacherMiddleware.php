<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // AdminMiddleware.php

// TeacherMiddleware.php
public function handle(Request $request, Closure $next)
{
    if (!auth()->check() || auth()->user()->Role !== 'teacher') {
        return response()->json(['error' => 'Unauthorized. Teacher access required.'], 403);
    }
    
    return $next($request);
}
}
