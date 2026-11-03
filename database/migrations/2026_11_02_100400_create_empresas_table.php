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
        Schema::create('empresas', function (Blueprint $table) {
            $table->unsignedInteger('IdUsuario')->primary();
            $table->unsignedInteger('IdClienteResponsable');
            $table->string('Ruc', 11)->nullable()->unique();
            $table->string('ReferenciaEnvio');
            $table->string('RazonSocial');
            $table->string('EstadoSunat', 50);
            $table->string('CondicionSunat', 50);
            $table->boolean('Validado')->default(false);
            $table->dateTime('FechaValidacion')->nullable();

            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios')
                ->cascadeOnDelete();
            $table->foreign('IdClienteResponsable')->references('IdUsuario')->on('clientes')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
