<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->is_authorized) {
            return response()->json(["message" => "Unauthorized"],401);
        }

        return $next($request);
    }
}
