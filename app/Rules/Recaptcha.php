<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\ValidationRule;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Verificar el token de reCAPTCHA con la API de Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.google.recaptcha.secret_key'),
            'response' => $value,
        ]);

        $result = $response->json();

        // Obtener el score de la respuesta
        $score = $result['score'] ?? null;

        // Loggear el score para auditoría
        Log::info('Verificación de reCAPTCHA', [
            'score' => $score,
            'response' => $result,
            'remote_ip' => request()->ip(),
        ]);

        // Verificar si la respuesta es exitosa y si el score es mayor a 0.5
        if ($response->successful() && $result['success'] && $score > 0.5) {
            return;
        }

        // Si no es válido, fallar la validación
        $fail('Recaptcha validation failed.');
    }
}
