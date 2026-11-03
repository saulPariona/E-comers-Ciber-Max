<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Quienes se registran con Google aún no informan su documento;
     * lo completan después. El UNIQUE sigue vigente (varios NULL son válidos).
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('TipoDocumento', 20)->nullable()->change();
            $table->integer('NumeroDocumento')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('TipoDocumento', 20)->nullable(false)->change();
            $table->integer('NumeroDocumento')->nullable(false)->change();
        });
    }
};
