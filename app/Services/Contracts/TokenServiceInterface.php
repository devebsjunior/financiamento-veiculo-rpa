<?php

namespace App\Services\Contracts;

use App\Models\User;

interface TokenServiceInterface
{
    /**
     * Gera um token JWT baseado no modelo do usuário (UUID).
     */
    public function generateToken(User $user): string;

    /**
     * Valida a integridade e a expiração do token informado.
     */
    public function validateToken(string $token): bool;

    /**
     * Extrai o Subject ('sub') de dentro do payload do token (o ID do usuário).
     */
    public function getSubjectFromToken(string $token): string;

    /**
     * Extrai todas as claims personalizadas contidas no token.
     */
    public function getClaimsFromToken(string $token): array;
}
