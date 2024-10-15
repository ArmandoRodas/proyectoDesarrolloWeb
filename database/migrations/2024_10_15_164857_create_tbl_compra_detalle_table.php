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
        Schema::create('tbl_compra_detalle', function (Blueprint $table) {
            $table->integer('id_compra_detalle', true);
            $table->integer('id_compra')->nullable()->index('id_compra');
            $table->integer('id_lote')->nullable()->index('id_lote');
            $table->string('nombre_producto_dcompra')->nullable();
            $table->integer('cantidad_producto_dcompra')->nullable();
            $table->decimal('precio_unitario_producto_dcompra', 10)->nullable();
            $table->decimal('subtotal_dcompra', 10)->nullable();
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
        Schema::dropIfExists('tbl_compra_detalle');
    }
};
