<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UserRepositoryInterface
{
    public function buscarTodos(): Collection;
    public function buscarPorId(string $id): ?User;
    public function buscarPorEmail(string $email): ?User;
    public function salvar(array $dados): User;
    public function atualizar(User $usuario, array $dados): User;
    public function deletar(User $usuario): bool;
}
