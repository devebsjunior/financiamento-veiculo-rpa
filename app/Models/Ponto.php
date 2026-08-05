<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data',
        'horarios',
        'total_horas',
        'observacao',
    ];

    protected $casts = [
        'horarios' => 'array',
        'data' => 'date:Y-m-d',
        'total_horas' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
