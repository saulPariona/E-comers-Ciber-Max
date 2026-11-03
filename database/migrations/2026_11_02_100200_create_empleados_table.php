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
        Schema::create('empleados', function (Blueprint $table) {
            $table->unsignedInteger('IdUsuario')->primary();
            $table->unsignedInteger('IdSupervisor')->nullable();
            $table->string('Area', 20);
            $table->string('Turno', 30);
            $table->date('FechaIngreso');

            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios')
                ->cascadeOnDelete();
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->foreign('IdSupervisor')->references('IdUsuario')->on('empleados')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
