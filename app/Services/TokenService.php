<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\TokenServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TokenService implements TokenServiceInterface
{
    public function generateToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }

    public function validateToken(string $token): bool
    {
        try {
            JWTAuth::setToken($token)->check();

            return true;
        } catch (JWTException $e) {
            return false;
        }
    }

    public function getSubjectFromToken(string $token): string
    {
        $payload = JWTAuth::setToken($token)->getPayload();

        return (string) $payload->get('sub');
    }

    public function getClaimsFromToken(string $token): array
    {
        $payload = JWTAuth::setToken($token)->getPayload();

        return $payload->toArray();
    }
}
