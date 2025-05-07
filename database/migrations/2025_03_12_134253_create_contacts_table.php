<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_empresa'); // Opción seleccionada en el Paso 1
            $table->string('producto_interesado'); // Opción seleccionada en el Paso 2
            $table->string('empresa'); // Empresa del usuario
            $table->string('nombre'); // Nombre de la persona
            $table->string('correo'); // Email 
            $table->string('telefono'); // Teléfono
            $table->string('provincia'); // Provincia
            $table->string('localidad'); // Localidad
            $table->boolean('politica_aceptada'); // Checkbox de política de privacidad
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('contacts');
    }
};
