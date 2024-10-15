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
        Schema::create('tbl_historial_cxc', function (Blueprint $table) {
            $table->integer('id_historial_cxc', true);
            $table->integer('id_cxc')->nullable()->index('id_cxc');
            $table->date('fecha_pago_historial_cxc')->nullable();
            $table->decimal('monto_pagado_historial_cxc', 10)->nullable();
            $table->integer('id_metodo_pago')->nullable()->index('id_metodo_pago');
            $table->string('referencia_pago_historial_cxc')->nullable();
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
        Schema::dropIfExists('tbl_historial_cxc');
    }
};
