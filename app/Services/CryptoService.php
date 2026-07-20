<?php

namespace App\Services;

use App\Services\Contracts\CryptoServiceInterface;
use Illuminate\Support\Facades\Hash;

class CryptoService implements CryptoServiceInterface
{
    public function hash(string $password): string
    {
        return Hash::make($password);
    }

    public function verify(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
