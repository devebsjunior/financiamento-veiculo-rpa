<?php

namespace App\Services\Contracts;

interface CryptoServiceInterface
{
    public function hash(string $password): string;
    public function verify(string $password, string $hashedPassword): bool;
}
