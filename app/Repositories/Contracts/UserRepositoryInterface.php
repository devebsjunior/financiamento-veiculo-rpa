<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{

    public function buscarPorEmail(string $email): ?User;
    public function salvar(array $dados): User;
    public function atualizar(User $usuario, array $dados): User;
    public function deletar(User $usuario): bool;
}
