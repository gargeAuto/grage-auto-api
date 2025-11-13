<?php

namespace App\Http\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class JwtService
{
    private string $key;

    public function __construct()
    {
        $this->key = env('JWT_SECRET', 'clé_super_secrète_inutile_en_prod');
    }

    public function generateToken( int $duration = 3600, User $user): string
    {
        $payload = [
            'role' => $user->role,
            'user_id' => $user->id,
            'iss' => config('app.url'),
            'aud' => config('app.url'),
            'iat' => time(),
            'exp' => time() + $duration,
        ];

        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function decodeToken(string $jwt): object
    {
        return JWT::decode($jwt, new Key($this->key, 'HS256'));
    }
}
