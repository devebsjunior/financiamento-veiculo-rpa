<?php

namespace App\Swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="550e8400-e29b-41d4-a716-446655440000"
 *     ),
 *
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         example="Edson Belém"
 *     ),
 *
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         example="edson@gmail.com"
 *     ),
 *
 *     @OA\Property(
 *         property="ativo",
 *         type="boolean",
 *         example=true
 *     )
 * )
 */
class UserSchema
{
}
