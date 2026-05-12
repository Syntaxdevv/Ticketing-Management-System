<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    if (auth()->check() && (strtolower(auth()->user()->role) === 'agent' || strtolower(auth()->user()->role) === 'admin')) {
        return $next($request);
    }
    return redirect('/dashboard')->with('error', 'Agents only.');
}
}
