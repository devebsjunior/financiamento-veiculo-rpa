<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $placa
 * @property string $marca
 * @property string $modelo
 * @property int $ano_fabricacao
 * @property int $ano_modelo
 * @property string|null $cor
 * @property string|null $renavam
 * @property string|null $chassi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Financiamento> $financiamentos
 * @property-read int|null $financiamentos_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereAnoFabricacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereAnoModelo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereChassi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereCor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereMarca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereModelo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo wherePlaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereRenavam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Veiculo whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Veiculo extends Model
{
    protected $table = 'veiculos';

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'ano_fabricacao',
        'ano_modelo',
        'cor',
        'renavam',
        'chassi',
    ];

    public function financiamentos(): HasMany
    {
        return $this->hasMany(Financiamento::class);
    }
}
