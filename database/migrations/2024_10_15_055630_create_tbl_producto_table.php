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
        Schema::create('tbl_producto', function (Blueprint $table) {
            $table->integer('id_producto', true);
            $table->string('sku_producto')->nullable();
            $table->string('cod_barra')->nullable();
            $table->string('nombre_producto')->nullable();
            $table->string('descripcion_producto')->nullable();
            $table->integer('id_marca')->nullable()->index('id_marca');
            $table->integer('id_subcategoria')->nullable()->index('id_subcategoria');
            $table->date('vencimiento_producto')->nullable();
            $table->decimal('precio_compra_producto', 10)->nullable();
            $table->decimal('precio_venta_producto', 10)->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_producto');
    }
};
