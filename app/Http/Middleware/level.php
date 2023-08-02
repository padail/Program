<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):(\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $level): Response
    {
        $allowedLevel = explode ('|', $level);
        if  (in_array($request->user()->level, $allowedLevel)) {
            return $next($request);
        }
        return redirect('/');
    }
}
