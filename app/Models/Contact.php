<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    /**
     * Los campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'sector_empresa',       // Sector seleccionado en el formulario
        'tipo_empresa',         // Tipo de empresa
        'desafios',             // Desafíos seleccionados (almacenados como JSON)
        'rol_empresa',          // Rol dentro de la empresa
        'momento_contacto',     // Momento preferido para el contacto
        'nombre',               // Nombre del contacto
        'correo',               // Correo electrónico
        'telefono',             // Teléfono
        'mensaje',              // Mensaje opcional
        'politica_aceptada',    // Aceptación de la política de privacidad
    ];

    /**
     * Los campos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'desafios' => 'array',          // Convertir el campo JSON a un array automáticamente
        'politica_aceptada' => 'boolean', // Convertir a booleano
    ];
}