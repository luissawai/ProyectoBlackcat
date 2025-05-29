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
        'sector',
        'sector_otro',
        'tipo_empresa',
        'desafios',
        'desafios_otros',
        'rol',
        'rol_otro',
        // 'momento_contacto',
        'nombre',
        'email',
        'telefono',
        'mensaje',
        'accepted_privacy',
        'fecha_envio'
    ];

    /**
     * Los campos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'desafios' => 'json', // Esto permitirá manejar JSON automáticamente
        'accepted_privacy' => 'boolean',
        'fecha_envio' => 'datetime',
    ];

    /**
     * Los campos que deben ocultarse en las arrays.
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Las reglas de validación para el modelo.
     */
    public static $rules = [
        'sector' => 'required|string',
        'sector_otro' => 'nullable|string|required_if:sector,otros',
        'tipo_empresa' => 'required|string',
        'desafios' => 'required|string',
        'rol' => 'required|string',
        'rol_otro' => 'nullable|string|required_if:rol,otros_rol',
        // 'momento_contacto' => 'required|string',
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telefono' => 'required|string|max:20',
        'mensaje' => 'nullable|string',
        'accepted_privacy' => 'required|boolean|accepted',
        'fecha_envio' => 'required|date',
    ];

    /**
     * Accesor para obtener los desafíos como array si están en formato JSON
     */
    public function getDesafiosArrayAttribute()
    {
        if (is_string($this->desafios) && json_decode($this->desafios) !== null) {
            return json_decode($this->desafios, true);
        }
        return $this->desafios;
    }

    /**
     * Mutador para asegurar que los desafíos se guarden en formato string
     */
    public function setDesafiosAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['desafios'] = implode(', ', $value);
        } else {
            $this->attributes['desafios'] = $value;
        }
    }
}