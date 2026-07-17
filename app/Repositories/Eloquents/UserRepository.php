<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function listarTodos(): Collection
    {
        return User::all();
    }

    public function buscarPorId(string $id): ?User
    {
        return User::find($id);
    }

    public function buscarPorEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function salvar(array $dados): User
    {
        return User::create($dados);
    }

    public function atualizar(User $usuario, array $dados): User
    {
        $usuario->update($dados);
        return $usuario;
    }

    public function deletar(User $usuario): bool
    {
        return $usuario->delete();
    }
}
