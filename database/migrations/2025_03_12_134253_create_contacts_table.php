<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('sector');
            $table->string('sector_otro')->nullable();
            $table->string('tipo_empresa')->nullable();
            $table->text('desafios');
            $table->text('desafios_otros')->nullable();
            $table->string('rol');
            $table->string('rol_otro')->nullable();
            $table->string('momento_contacto');
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono');
            $table->text('mensaje')->nullable();
            $table->boolean('accepted_privacy');
            $table->timestamp('fecha_envio');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
