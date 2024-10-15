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
        Schema::create('tbl_traslado', function (Blueprint $table) {
            $table->integer('id_traslado', true);
            $table->date('fecha_traslado')->nullable();
            $table->string('descripcion_traslado')->nullable();
            $table->string('documento_traslado')->nullable();
            $table->integer('id_bodega_origen')->nullable()->index('id_bodega_origen');
            $table->integer('id_bodega_destino')->nullable()->index('id_bodega_destino');
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
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
        Schema::dropIfExists('tbl_traslado');
    }
};
