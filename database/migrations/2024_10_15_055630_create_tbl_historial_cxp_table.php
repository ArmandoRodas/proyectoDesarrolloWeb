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
        Schema::create('tbl_historial_cxp', function (Blueprint $table) {
            $table->integer('id_historial_cxp', true);
            $table->integer('id_cxp')->nullable()->index('id_cxp');
            $table->date('fecha_pago_historial_cxp')->nullable();
            $table->decimal('monto_pagado_historial_cxp', 10)->nullable();
            $table->integer('id_metodo_pago')->nullable()->index('id_metodo_pago');
            $table->string('referencia_pago_historial_cxp')->nullable();
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
        Schema::dropIfExists('tbl_historial_cxp');
    }
};
