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
        Schema::create('clientes', function (Blueprint $table) {
            $table->unsignedInteger('IdUsuario')->primary();
            $table->string('DireccionEnvio')->nullable();
            $table->string('ReferenciaEnvio')->nullable();
            $table->string('Ubigeo', 6)->nullable();

            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
