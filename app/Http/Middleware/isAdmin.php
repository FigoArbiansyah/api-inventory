<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role_id != Role::ADMINISTRATOR) {
            return ResponseHelper::error('Unauthorized', 401);
        }
        return $next($request);
    }
}
