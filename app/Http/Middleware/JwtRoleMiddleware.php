<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Priorité au rôle injecté par JwtMiddleware (jwt_role)
        $currentRole = $request->get('jwt_role');

        // Si pas de jwt_role, on tente le user() (session/guard)
        if ($currentRole === null) {
            $user = $request->user();
            $currentRole = $user->role ?? null;
        }

        if ($currentRole !== $role) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        return $next($request);
    }
}
