<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieAudit extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'cookie_audit';

    // Definir los campos que son asignables masivamente
    protected $fillable = [
        'uuid',
        'ip_address',
        'user_agent',
        'accepted_cookies',
        'consent_status',
    ];

    // Definir los campos que deberían ser tratados como fechas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Para que 'accepted_cookies' sea convertido en un array o JSON
    protected $casts = [
        'accepted_cookies' => 'array',
    ];
}