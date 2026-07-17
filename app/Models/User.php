<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $id
 * @property string $nome
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $ativo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use HasUuids;
    use Notifiable;

    protected $table = 'users';

    /**
     * O tipo de ID do banco de dados (UUID).
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Desliga o auto-incremento numérico para aceitar strings.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Retorna o identificador do JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Retorna um array com claims personalizadas para o JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
