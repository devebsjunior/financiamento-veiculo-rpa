<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string|null $data_nascimento
 * @property string|null $telefone
 * @property string|null $email
 * @property string|null $cep
 * @property string|null $logradouro
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $cidade
 * @property string|null $uf
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Financiamento> $financiamentos
 * @property-read int|null $financiamentos_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereBairro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereDataNascimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereLogradouro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereTelefone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'telefone',
        'email',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'uf',
    ];

    public function financiamentos(): HasMany
    {
        return $this->hasMany(Financiamento::class);
    }
}
