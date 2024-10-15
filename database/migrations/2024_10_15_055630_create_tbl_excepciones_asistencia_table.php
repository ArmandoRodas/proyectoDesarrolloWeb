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
        Schema::create('tbl_excepciones_asistencia', function (Blueprint $table) {
            $table->integer('id_excepcion', true);
            $table->integer('id_empleado')->nullable()->index('id_empleado');
            $table->date('fecha')->nullable();
            $table->string('tipo_excepcion')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('aprobado_por')->nullable()->index('aprobado_por');
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_excepciones_asistencia');
    }
};
