<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\GlobalException;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\CryptoServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private CryptoServiceInterface $cryptoService,
        private TokenServiceInterface $tokenService
    ) {}

    public function listar(): Collection
    {
        return $this->repository->buscarTodos();
    }

    public function buscar(string $id): User
    {
        $usuario = $this->repository->buscarPorId($id);
        if (!$usuario) {
            throw new GlobalException("Usuário com o ID {$id} não foi encontrado.", 404);
        }
        return $usuario;
    }

    public function cadastrar(array $dados): array
    {
        if ($this->repository->buscarPorEmail($dados['email'])) {
            throw new GlobalException("Este e-mail já está cadastrado no sistema.", 422);
        }
        $dados['password'] = $this->cryptoService->hash($dados['password']);
        $usuario = $this->repository->salvar($dados);
        $token = $this->tokenService->generateToken($usuario);
        return [
            'user'  => $usuario,
            'token' => $token
        ];
    }

    public function atualizar(string $id, array $dados): User
    {
        $usuario = $this->buscar($id);
        if (!empty($dados['password'])) {
            $dados['password'] = $this->cryptoService->hash($dados['password']);
        } else {
            unset($dados['password']);
        }
        return $this->repository->atualizar($usuario, $dados);
    }

    public function excluir(string $id): void
    {
        $usuario = $this->buscar($id);
        $this->repository->deletar($usuario);
    }
}
