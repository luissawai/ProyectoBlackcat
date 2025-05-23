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
        Log::info('Received form data:', $request->all());
        
        $validated = $request->validated();
        Log::info('Validated data:', $validated);

        $contactData = [
            'sector' => $validated['sector'],
            'sector_otro' => $validated['sector_otro'] ?? null,
            'tipo_empresa' => $validated['sector'] === 'otros' ? null : ($validated['tipo_empresa'] ?? null),
            'desafios' => $validated['sector'] === 'otros' 
                ? $validated['desafios_otros']
                : (is_array($validated['desafios']) 
                    ? implode(', ', $validated['desafios']) 
                    : $validated['desafios']),
            'desafios_otros' => $validated['desafios_otros'] ?? null,
            'rol' => $validated['rol'],
            'rol_otro' => $validated['rol_otro'] ?? null,
            'momento_contacto' => $validated['momento_contacto'],
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'mensaje' => $validated['mensaje'] ?? null,
            'accepted_privacy' => $validated['accepted_privacy'],
            'fecha_envio' => now()
        ];

        Log::info('Contact data to save:', $contactData);

        $contact = Contact::create($contactData);

        if (!$contact->exists) {
            throw new Exception('Error al guardar el formulario en la base de datos.');
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Mensaje enviado con éxito',
            'data' => ['contact_id' => $contact->id]
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error details:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
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
            'momento_contacto' => '',
            'nombre' => '',
            'email' => '',
            'telefono' => '',
            'mensaje' => '',
            'accepted_privacy' => false
        ];
    }
}
