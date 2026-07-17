<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $cliente_id
 * @property int $veiculo_id
 * @property string $numero_contrato
 * @property numeric $valor_veiculo
 * @property numeric $valor_entrada
 * @property numeric $valor_financiado
 * @property numeric $taxa_juros
 * @property int $quantidade_parcelas
 * @property string $data_contratacao
 * @property string $situacao
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cliente $cliente
 * @property-read Collection<int, Parcela> $parcelas
 * @property-read int|null $parcelas_count
 * @property-read Veiculo $veiculo
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereDataContratacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereNumeroContrato($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereQuantidadeParcelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereSituacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereTaxaJuros($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereValorEntrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereValorFinanciado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereValorVeiculo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Financiamento whereVeiculoId($value)
 *
 * @mixin \Eloquent
 */
class Financiamento extends Model
{
    protected $table = 'financiamentos';

    protected $fillable = [
        'cliente_id',
        'veiculo_id',
        'numero_contrato',
        'valor_veiculo',
        'valor_entrada',
        'valor_financiado',
        'taxa_juros',
        'quantidade_parcelas',
        'data_contratacao',
        'situacao',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function parcelas(): HasMany
    {
        return $this->hasMany(Parcela::class);
    }
}
