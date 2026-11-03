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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('IdUsuario');
            $table->integer('IdRol');
            $table->string('CodigoUsuario', 30)->unique();
            $table->string('TipoDocumento', 20);
            $table->integer('NumeroDocumento')->unique();
            $table->string('Nombres');
            $table->string('Apellidos');
            $table->string('Telefono', 20)->nullable();
            $table->date('Fecha_Nacimiento')->nullable();
            $table->string('Email')->nullable()->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('Password')->nullable();
            $table->string('Google_id')->nullable();
            $table->string('Remember_token', 100)->nullable();
            $table->string('Foto')->nullable();
            $table->boolean('Estado')->default(true);

            $table->foreign('IdRol')->references('IdRol')->on('roles')
                ->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
