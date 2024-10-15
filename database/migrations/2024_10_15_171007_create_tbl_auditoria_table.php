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
        Schema::create('tbl_auditoria', function (Blueprint $table) {
            $table->integer('id_auditoria', true);
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->string('tabla_afectada')->nullable();
            $table->string('accion_realizada')->nullable();
            $table->timestamp('fecha_accion')->nullable()->useCurrent();
            $table->text('datos_previos')->nullable();
            $table->text('datos_nuevos')->nullable();
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
        Schema::dropIfExists('tbl_auditoria');
    }
};
