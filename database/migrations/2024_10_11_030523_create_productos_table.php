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
            $table->id('id_producto');
            $table->string('sk_producto', 255)->nullable();
            $table->string('cod_barra', 255)->nullable();
            $table->string('nombre_producto', 255)->nullable();
            $table->string('descripcion_producto', 255)->nullable();
            $table->unsignedBigInteger('id_marca')->nullable();
            $table->unsignedBigInteger('id_subcategoria')->nullable();
            $table->date('vencimiento')->nullable();
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->unsignedBigInteger('id_sucursal')->nullable();

            // Si vas a tener relaciones foráneas, puedes agregarlas aquí.
             $table->foreign('id_marca')->references('id_marca')->on('tbl_marca');
             $table->foreign('id_subcategoria')->references('id_subcategoria')->on('tbl_subcategoria');
             $table->foreign('id_empresa')->references('id_empresa')->on('tbl_empresa');
             $table->foreign('id_sucursal')->references('id_sucursal')->on('tbl_sucursal');
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
