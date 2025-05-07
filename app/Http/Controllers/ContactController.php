<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ContactConfirmationMail;
use App\Rules\Recaptcha;
use Exception;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Log::info('==== INICIO DEL PROCESO DE CONTACTO ====');
            Log::info('Validando formulario', ['ip' => $request->ip(), 'data' => $request->except('recaptcha_token')]);

            // Validación de los datos del formulario
            $validatedData = $request->validate([
                'tipo_empresa' => 'required|string|max:255',
                'producto_interesado' => 'required|string|max:255',
                'empresa' => 'required|string|max:255',
                'nombre' => 'required|string|max:255',
                'correo' => 'required|email|max:255',
                'telefono' => 'required|string|max:20',
                'provincia' => 'required|string|max:255',
                'localidad' => 'required|string|max:255',
                'politica_aceptada' => 'required|accepted',
                'recaptcha_token' => ['required', new Recaptcha()], // Validación de reCAPTCHA
            ]);

            Log::info('Validación exitosa');

            // Limpiar datos sensibles
            $contactData = [
                'tipo_empresa' => $validatedData['tipo_empresa'],
                'producto_interesado' => $validatedData['producto_interesado'],
                'empresa' => $validatedData['empresa'],
                'nombre' => $validatedData['nombre'],
                'correo' => filter_var($validatedData['correo'], FILTER_SANITIZE_EMAIL),
                'telefono' => filter_var($validatedData['telefono'], FILTER_SANITIZE_STRING),
                'provincia' => $validatedData['provincia'],
                'localidad' => $validatedData['localidad'],
                'politica_aceptada' => $validatedData['politica_aceptada'],
            ];

            Log::info('Intentando crear registro en BD', ['data' => $contactData]);

            // Crear el registro en la base de datos
            $contact = Contact::create($contactData);
            
            if (!$contact->exists) {
                throw new Exception('El registro no se creó correctamente en la base de datos');
            }

            Log::info('Registro creado exitosamente', [
                'id' => $contact->id,
                'created_at' => $contact->created_at
            ]);

            // Enviar correo electrónico
            Log::info('Preparando envío de email');
            Mail::to(config('mail.from.address'))->send(new ContactConfirmationMail($contact));
            Log::info('Email enviado correctamente');

            DB::commit();

            Log::info('==== PROCESO COMPLETADO CON ÉXITO ====');

            return response()->json([
                'success' => 'Formulario enviado correctamente!',
                'data' => $contact
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación', [
                'errors' => $e->errors(),
                'input' => $request->except('recaptcha_token')
            ]);
            
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Error de validación en el formulario'
            ], 422);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error en el proceso de contacto', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_data' => $request->except('recaptcha_token')
            ]);

            return response()->json([
                'error' => 'Error al enviar el formulario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show()
    {
        return Inertia::render('Contacto/Form');
    }

}