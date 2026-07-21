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
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID (UUID)',
            'Nome Completo',
            'E-mail',
            'Status',
            'Data de Cadastro'
        ];
    }

    /**
     * Mapeamento de cada linha para evitar vazamento de hash de senhas
     *
     * @param User $user
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->nome,
            $user->email,
            $user->ativo ? 'Ativo' : 'Inativo',
            $user->created_at ? $user->created_at->format('d/m/Y H:i') : ''
        ];
    }
}
