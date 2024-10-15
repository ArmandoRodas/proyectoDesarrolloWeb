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
        Schema::create('tbl_conversion_producto', function (Blueprint $table) {
            $table->integer('id_conversion', true);
            $table->integer('id_producto_original')->nullable()->index('id_producto_original');
            $table->decimal('cantidad_original', 10)->nullable();
            $table->string('unidad_original', 50)->nullable();
            $table->integer('id_producto_convertido')->nullable()->index('id_producto_convertido');
            $table->decimal('cantidad_convertida', 10)->nullable();
            $table->string('unidad_convertida', 50)->nullable();
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
        Schema::dropIfExists('tbl_conversion_producto');
    }
};
