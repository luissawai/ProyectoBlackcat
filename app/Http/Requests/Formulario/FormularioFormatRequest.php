<?php

namespace App\Http\Requests\Formulario;

use Illuminate\Foundation\Http\FormRequest;

class FormularioFormatRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sector' => 'required|string',
            'sector_otro' => 'required_if:sector,otros|nullable|string',
            'tipo_empresa' => 'required_unless:sector,otros|nullable|string',
            'desafios' => 'required_unless:sector,otros',
            'desafios_otros' => 'required_if:sector,otros|nullable|string',
            'rol' => 'required|string',
            'rol_otro' => 'required_if:rol,otros_rol|nullable|string',
            // 'momento_contacto' => 'required|string',
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'mensaje' => 'nullable|string',
            'accepted_privacy' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'accepted_privacy.accepted' => 'Debes aceptar la política de privacidad',
            'sector.required' => 'Por favor selecciona un sector',
            'tipo_empresa.required_unless' => 'El tipo de empresa es requerido cuando no se selecciona "otros" como sector',
            'desafios.required_unless' => 'Por favor indica los desafíos de tu empresa',
            'rol.required' => 'Por favor selecciona tu rol',
            // 'momento_contacto.required' => 'Por favor selecciona cuándo prefieres que te contactemos',
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'Por favor ingresa un email válido',
            'telefono.required' => 'El teléfono es requerido',
        ];
    }
}
