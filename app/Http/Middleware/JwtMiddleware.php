<?php

namespace App\Http\Middleware;

use App\Http\Services\JwtService;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JwtMiddleware
{
    private JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Token manquant'], 401);
        }

        $token = substr($header, 7); // enlève "Bearer "

        try {
            $decoded = $this->jwtService->decodeToken($token);
        } catch (Exception $e) {
            return response()->json(['message' => 'Token invalide ou expiré'], 401);
        }

            // On injecte les données du token dans la requête
            $request->merge([
                'jwt_user_id' => $decoded->user_id ?? null,
                'jwt_role' => $decoded->role ?? null,
            ]);

            // Si l'ID utilisateur est présent dans le token, on récupère l'utilisateur
            // et on l'attache à l'Auth guard et au Request afin que $request->user() et
            // les middlewares comme 'verified' fonctionnent correctement.
            $userId = $decoded->user_id ?? null;
            if ($userId) {
                $user = User::find($userId);
                if (! $user) {
                    return response()->json(['message' => 'Utilisateur introuvable'], 401);
                }

                // Attacher l'utilisateur à l'auth guard courant
                Auth::setUser($user);

                // Assurer que $request->user() retourne bien cet utilisateur
                $request->setUserResolver(function () use ($user) {
                    return $user;
                });
            }

        return $next($request);
    }
}
