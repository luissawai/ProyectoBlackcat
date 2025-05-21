<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('sector_empresa'); // Sector seleccionado en el Paso 1
            $table->string('tipo_empresa')->nullable(); // Tipo de empresa seleccionado en el Paso 2 (puede ser null si se seleccionó "Otros")
            $table->json('desafios')->nullable(); // Desafíos seleccionados en el Paso 3 (almacenados como JSON)
            $table->string('rol_empresa'); // Rol seleccionado en el Paso 4
            $table->string('momento_contacto'); // Momento de contacto seleccionado en el Paso 5
            $table->string('nombre'); // Nombre del usuario
            $table->string('correo'); // Correo electrónico
            $table->string('telefono'); // Teléfono
            $table->text('mensaje')->nullable(); // Mensaje opcional del usuario
            $table->boolean('politica_aceptada'); // Checkbox de política de privacidad
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('contacts');
    }
};