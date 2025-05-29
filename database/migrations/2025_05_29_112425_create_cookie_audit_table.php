<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cookie_audit', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // Identificador único de usuario
            $table->string('ip_address', 45); // Dirección IP
            $table->text('user_agent'); 
            $table->json('accepted_cookies'); 
            $table->enum('consent_status', ['aceptado', 'rechazado', 'personalizado']); 
            $table->timestamps(); // created_at para saber la fecha de la aceptación
        });
    }

    /*
    uuid → Se usa para identificar sesiones anónimas sin exponer información personal.
    ip_address y user_agent → Necesarios para auditorías y cumplimiento normativo.
    accepted_cookies → Guarda un JSON con las cookies aceptadas/rechazadas.
    consent_status → Guarda si el usuario aceptó todas, rechazó o personalizó su configuración.
    timestamps() → Guarda la fecha exacta del consentimiento.

    */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabla `cookie_audit` si se necesita revertir la migración
        Schema::dropIfExists('cookie_audit');
    }
};
