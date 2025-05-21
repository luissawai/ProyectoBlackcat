<?php


namespace App\Http\Requests\Formulario;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class FormularioFormatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para los campos del formulario.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tipo_empresa' => ['required', 'string', 'max:255'],
            'producto_interesado' => ['required', 'string', 'max:255'],
            'empresa' => ['required', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'provincia' => ['required', 'string', 'max:255'],
            'localidad' => ['required', 'string', 'max:255'],
            'politica_aceptada' => ['required', 'accepted'],
            'recaptcha_token' => ['required', new Recaptcha()],
        ];
    }

    /**
     * Mensajes de error personalizados.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'tipo_empresa.required' => 'Por favor, selecciona el tipo de empresa.',
            'tipo_empresa.string' => 'El tipo de empresa debe ser un texto válido.',

            'producto_interesado.required' => 'Por favor, selecciona el producto de interés.',
            'producto_interesado.string' => 'El producto de interés debe ser un texto válido.',

            'empresa.required' => 'Por favor, indica el nombre de tu empresa.',
            'empresa.string' => 'El nombre de la empresa debe ser un texto válido.',

            'nombre.required' => 'Por favor, ingresa tu nombre.',
            'nombre.string' => 'El nombre debe contener solo texto.',

            'correo.required' => 'Necesitamos tu correo electrónico para contactarte.',
            'correo.email' => 'El correo electrónico no tiene un formato válido.',

            'telefono.required' => 'Por favor, indica un número de teléfono.',
            'telefono.string' => 'El teléfono debe contener solo números y/o texto.',

            'provincia.required' => 'Por favor, selecciona tu provincia.',
            'provincia.string' => 'La provincia debe ser un texto válido.',

            'localidad.required' => 'Por favor, selecciona tu localidad.',
            'localidad.string' => 'La localidad debe ser un texto válido.',

            'politica_aceptada.required' => 'Debes aceptar la política de privacidad.',
            'politica_aceptada.accepted' => 'Debes aceptar la política de privacidad.',

            'recaptcha_token.required' => 'La validación de reCAPTCHA es obligatoria.',
        ];
    }
}