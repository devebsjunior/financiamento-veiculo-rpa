<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $financiamento_id
 * @property int $numero_parcela
 * @property string $data_vencimento
 * @property numeric $valor_parcela
 * @property numeric|null $valor_pago
 * @property string|null $data_pagamento
 * @property string $situacao
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Financiamento $financiamento
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereDataPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereDataVencimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereFinanciamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereNumeroParcela($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereSituacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereValorPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parcela whereValorParcela($value)
 *
 * @mixin \Eloquent
 */
class Parcela extends Model
{
    protected $table = 'parcelas';

    protected $fillable = [
        'financiamento_id',
        'numero_parcela',
        'data_vencimento',
        'valor_parcela',
        'valor_pago',
        'data_pagamento',
        'situacao',
    ];

    public function financiamento(): BelongsTo
    {
        return $this->belongsTo(Financiamento::class);
    }
}
