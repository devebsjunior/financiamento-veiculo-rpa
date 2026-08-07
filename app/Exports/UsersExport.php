<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
       return User::select('nome', 'email', 'ativo', 'created_at')->get();
    }

    public function headings(): array
    {
       return ['Nome', 'E-mail', 'Ativo', 'Data de Cadastro'];
    }

    /**
     * Mapeamento de cada linha para evitar vazamento de hash de senhas
     *
     * @param User $user
     */
    public function map($user): array
    {
        return [
            $user->nome,
            $user->email,
            $user->ativo ? 'Ativo' : 'Inativo',
            $user->created_at ? $user->created_at->format('d/m/Y H:i') : ''
        ];
    }
}
