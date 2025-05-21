<?php

namespace App\Http\Controllers;

use App\Http\Requests\Formulario\FormularioFormatRequest;
use App\Mail\ContactConfirmationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Exception;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('/', [
            'recaptcha_key' => null, // Eliminado el uso de reCAPTCHA
        ]);
    }

    public function store(FormularioFormatRequest $request)
    {
        DB::beginTransaction();

        try {
            Log::info('==== INICIO DEL PROCESO DE CONTACTO ====');
            Log::info('Validando formulario', [
                'ip' => $request->ip(),
                'data' => $request->all() // Eliminado el `except('recaptcha_token')`
            ]);

            // Validación realizada automáticamente por FormularioFormatRequest
            $validated = $request->validated();

            Log::info('Validación exitosa del formulario de contacto.');

            // Preparar datos para guardar en la base de datos
            $contactData = collect($validated)->toArray(); // Eliminado el `except('recaptcha_token')`

            // Guardar en base de datos
            Log::info('Intentando crear registro en BD', ['data' => $contactData]);
            $contact = Contact::create($contactData);

            if (!$contact->exists) {
                throw new Exception('No se pudo guardar el formulario en la base de datos.');
            }

            Log::info('Contacto guardado exitosamente', [
                'id' => $contact->id,
                'created_at' => $contact->created_at
            ]);

            // Enviar correo de confirmación
            Mail::to($validated['correo'])->send(new ContactConfirmationMail($contact));

            Log::info('Correo enviado correctamente.');

            DB::commit();

            Log::info('==== PROCESO COMPLETADO CON ÉXITO ====');

            return Inertia::render('/', [
                'success' => 'Mensaje enviado con éxito!',
                'form' => array_fill_keys(['tipo_empresa', 'producto_interesado', 'empresa', 'nombre', 'correo', 'telefono', 'provincia', 'localidad', 'mensaje'], ''),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación', [
                'errors' => $e->errors(),
                'input' => $request->all() // Eliminado el `except('recaptcha_token')`
            ]);
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error en el proceso de contacto', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input_data' => $request->all() // Eliminado el `except('recaptcha_token')`
            ]);

            return Inertia::render('/', [
                'error' => 'Error al procesar el formulario: ' . $e->getMessage(),
                'form' => $request->all(), // Eliminado el `except('recaptcha_token')`
            ]);
        }
    }
}