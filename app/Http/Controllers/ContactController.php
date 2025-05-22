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
            'form' => $this->getEmptyFormData()
        ]);
    }

    public function store(FormularioFormatRequest $request)
    {
        DB::beginTransaction();

        try {
            Log::info('==== INICIO DEL PROCESO DE CONTACTO ====', [
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            // Validación realizada por FormularioFormatRequest
            $validated = $request->validated();

            // Preparar datos para guardar
            $contactData = [
                'sector' => $validated['sector'],
                'sector_otro' => $validated['sector_otro'] ?? null,
                'tipo_empresa' => $validated['tipo_empresa'],
                'desafios' => is_array($validated['desafios']) 
                    ? implode(', ', $validated['desafios']) 
                    : $validated['desafios'],
                'rol' => $validated['rol'],
                'rol_otro' => $validated['rol_otro'] ?? null,
                'momento_contacto' => $validated['momento_contacto'],
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'mensaje' => $validated['mensaje'],
                'accepted_privacy' => $validated['accepted_privacy'],
                'fecha_envio' => now(),
            ];

            Log::info('Datos preparados para guardar', ['data' => $contactData]);

            // Guardar en base de datos
            $contact = Contact::create($contactData);

            if (!$contact->exists) {
                throw new Exception('Error al guardar el formulario en la base de datos.');
            }

            // Enviar correo
            try {
                Mail::to($validated['email'])->send(new ContactConfirmationMail($contact));
                Log::info('Correo enviado correctamente.');
            } catch (Exception $e) {
                Log::error('Error al enviar correo', [
                    'error' => $e->getMessage(),
                    'email' => $validated['email']
                ]);
                // Continuar el proceso aunque falle el email
            }

            DB::commit();
            Log::info('==== PROCESO COMPLETADO CON ÉXITO ====');

            return response()->json([
                'status' => 'success',
                'message' => 'Mensaje enviado con éxito'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación', [
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error en el proceso de contacto', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Ha ocurrido un error al procesar tu solicitud.'
            ], 500);
        }
    }

    private function getEmptyFormData(): array
    {
        return [
            'sector' => '',
            'sector_otro' => '',
            'tipo_empresa' => '',
            'desafios' => [],
            'rol' => '',
            'rol_otro' => '',
            'momento_contacto' => '',
            'nombre' => '',
            'email' => '',
            'telefono' => '',
            'mensaje' => '',
            'accepted_privacy' => false
        ];
    }
}