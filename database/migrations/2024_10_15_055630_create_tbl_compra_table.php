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
        Schema::create('tbl_compra', function (Blueprint $table) {
            $table->integer('id_compra', true);
            $table->date('fecha_compra')->nullable();
            $table->decimal('monto_total_compra', 10)->nullable();
            $table->string('descripcion_compra')->nullable();
            $table->string('referencia')->nullable();
            $table->integer('id_metodo_pago')->nullable()->index('id_metodo_pago');
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->integer('id_tipoCompra')->nullable()->index('id_tipocompra');
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->integer('id_persona')->nullable()->index('id_persona');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
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
        Schema::dropIfExists('tbl_compra');
    }
};
