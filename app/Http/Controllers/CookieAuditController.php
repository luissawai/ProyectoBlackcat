<?php
namespace App\Http\Controllers;

use App\Models\CookieAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CookieAuditController extends Controller
{
    // Función para registrar el consentimiento de cookies
    public function storeConsent(Request $request)
    {
        // Log para ver todo el contenido del request
        Log::info('Contenido completo del request', [
            'request_data' => $request->all(),
        ]);

        // Validar los datos del request si es necesario
        $validatedData = $request->validate([
            'consentStatus' => 'required|in:aceptado,rechazado,personalizado',
            'acceptedCookies' => 'required|array',
        ]);

        // Obtener el UUID del usuario o generar uno nuevo (puedes usar una variable de sesión o un identificador del usuario)
        $uuid = Str::uuid();

        // Crear un registro de auditoría de cookies con los datos crudos
        $cookieAudit = CookieAudit::create([
            'uuid' => $uuid,  // Generar un UUID único para la sesión del usuario
            'ip_address' => $request->ip(),  // Obtener la dirección IP
            'user_agent' => $request->userAgent(),  // Obtener el User-Agent
            'accepted_cookies' => json_encode($validatedData['acceptedCookies']),  // Almacenar las cookies aceptadas en crudo
            'consent_status' => $validatedData['consentStatus'],  // Estado del consentimiento en crudo
        ]);

        // Log para verificar si se guardó correctamente
        Log::info('Consentimiento guardado en la base de datos', [
            'cookie_audit' => $cookieAudit
        ]);

        // Retornar una respuesta Inertia, por ejemplo, redirigiendo al usuario a otra página
        return response()->json([
            'message' => 'Consentimiento de cookies registrado correctamente.',
            'data' => $cookieAudit
        ], 200);
    }

    // Función para obtener la auditoría de un usuario
    public function getConsent($uuid)
    {
        // Buscar el registro de la auditoría por UUID
        $cookieAudit = CookieAudit::where('uuid', $uuid)->first();

        // Verificar si el registro existe
        if (!$cookieAudit) {
            return response()->json([
                'message' => 'No se encontró el registro de consentimiento para este usuario.'
            ], 404);
        }

        // Retornar los datos de auditoría
        return response()->json([
            'data' => $cookieAudit
        ], 200);
    }
}