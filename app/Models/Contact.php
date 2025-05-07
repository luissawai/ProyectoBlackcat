<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'tipo_empresa',
        'producto_interesado',
        'empresa',
        'nombre',
        'correo',
        'telefono',
        'provincia',
        'localidad',
        'politica_aceptada',
    ];
}
