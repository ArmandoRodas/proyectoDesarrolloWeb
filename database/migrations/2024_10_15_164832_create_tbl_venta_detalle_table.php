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
        Schema::create('tbl_venta_detalle', function (Blueprint $table) {
            $table->integer('id_venta_detalle', true);
            $table->integer('id_venta')->nullable()->index('id_venta');
            $table->integer('id_producto')->nullable()->index('id_producto');
            $table->integer('id_lote')->nullable()->index('id_lote');
            $table->integer('cantidad_venta_detalle')->nullable();
            $table->decimal('descuento_venta_detalle', 10)->nullable();
            $table->decimal('subtotal_venta_detalle', 10)->nullable();
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
        Schema::dropIfExists('tbl_venta_detalle');
    }
};
