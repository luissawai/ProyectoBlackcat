<?php

namespace App\Http\Requests\Formulario;

use Illuminate\Foundation\Http\FormRequest;

class FormularioFormatRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sector' => 'required|string',
            'sector_otro' => 'nullable|string|required_if:sector,otros',
            'tipo_empresa' => 'required|string',
            'desafios' => 'required_unless:sector,otros',  
            'rol' => 'required|string',
            'rol_otro' => 'nullable|string|required_if:rol,otros_rol',
            'momento_contacto' => 'required|string',
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'nullable|string|max:1000',
            'accepted_privacy' => 'required|boolean|accepted',
        ];
    }

    public function messages()
    {
        return [
            'accepted_privacy.accepted' => 'Debes aceptar la política de privacidad',
            'sector.required' => 'Por favor selecciona un sector',
            'tipo_empresa.required' => 'Por favor selecciona un tipo de empresa',
            'desafios.required_unless' => 'Por favor indica los desafíos de tu empresa',
            'rol.required' => 'Por favor selecciona tu rol',
            'momento_contacto.required' => 'Por favor selecciona cuándo prefieres que te contactemos',
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'Por favor ingresa un email válido',
            'telefono.required' => 'El teléfono es requerido',
        ];
    }
}