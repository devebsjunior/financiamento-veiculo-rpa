<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function listar(): Collection;
    public function buscar(string $id): User;
    public function atualizar(string $id, array $dados): User;
    public function excluir(string $id): void;
    public function cadastrar(array $dados): array;
}
