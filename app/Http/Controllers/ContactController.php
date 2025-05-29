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
                'timestamp' => now(),
                'request_data' => $request->all()
            ]);

            $validated = $request->validated();
            Log::info('Validated data:', $validated);

            // Validate required fields explicitly
            if (!isset($validated['sector'])) {
                throw new Exception('El campo sector es requerido');
            }

            // Procesar desafíos
            $desafiosProcessed = '';
            if ($validated['sector'] === 'otros') {
                $desafiosProcessed = $validated['desafios_otros'] ?? '';
            } else {
                if (is_string($validated['desafios'])) {
                    // Intentar decodificar como JSON
                    $desafiosArray = json_decode($validated['desafios'], true);
                    if ($desafiosArray && is_array($desafiosArray)) {
                        // Si es JSON válido con objetos, guardarlo como JSON
                        $desafiosProcessed = $validated['desafios'];
                    } else {
                        // Si no es JSON, es un string simple
                        $desafiosProcessed = $validated['desafios'];
                    }
                } elseif (is_array($validated['desafios'])) {
                    // Si viene como array, convertir a JSON
                    $desafiosProcessed = json_encode($validated['desafios']);
                }
            }

            Log::info('Desafíos procesados:', [
                'original' => $validated['desafios'] ?? 'null',
                'processed' => $desafiosProcessed
            ]);

            $contactData = [
                'sector' => $validated['sector'],
                'sector_otro' => $validated['sector_otro'] ?? null,
                'tipo_empresa' => $validated['sector'] === 'otros' ? null : ($validated['tipo_empresa'] ?? null),
                'desafios' => $desafiosProcessed,
                'desafios_otros' => $validated['desafios_otros'] ?? null,
                'rol' => $validated['rol'] ?? null,
                'rol_otro' => $validated['rol_otro'] ?? null,
                // 'momento_contacto' => $validated['momento_contacto'] ?? null,
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'mensaje' => $validated['mensaje'] ?? null,
                'accepted_privacy' => $validated['accepted_privacy'] ?? false,
                'fecha_envio' => now()
            ];

            Log::info('Contact data to save:', $contactData);

            try {
                $contact = Contact::create($contactData);
            } catch (\Exception $e) {
                Log::error('Error creating contact:', [
                    'error' => $e->getMessage(),
                    'data' => $contactData
                ]);
                throw new Exception('Error al crear el contacto: ' . $e->getMessage());
            }

            if (!$contact->exists) {
                throw new Exception('Error al guardar el formulario en la base de datos.');
            }

            // Enviar correo electrónico
            try {
                Log::info('Iniciando envío de correo', [
                    'email' => $contact->email,
                    'timestamp' => now()
                ]);

                Mail::to($contact->email)->send(new ContactConfirmationMail($contact));

                Log::info('Correo enviado exitosamente', [
                    'email' => $contact->email,
                    'timestamp' => now()
                ]);
            } catch (\Exception $e) {
                Log::error('Error enviando correo', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'email' => $contact->email
                ]);
                // No hacemos throw aquí para que el proceso continúe aunque falle el correo
            }

            DB::commit();
            Log::info('==== PROCESO COMPLETADO CON ÉXITO ====');

            return response()->json([
                'status' => 'success',
                'message' => 'Mensaje enviado con éxito',
                'data' => ['contact_id' => $contact->id]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en el proceso de contacto:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Ha ocurrido un error al procesar tu solicitud.',
                'debug' => config('app.debug') ? $e->getMessage() : null
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
            // 'momento_contacto' => '',
            'nombre' => '',
            'email' => '',
            'telefono' => '',
            'mensaje' => '',
            'accepted_privacy' => false
        ];
    }
}
