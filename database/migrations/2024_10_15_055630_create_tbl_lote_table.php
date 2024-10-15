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
        Schema::create('tbl_lote', function (Blueprint $table) {
            $table->integer('id_lote', true);
            $table->string('numero_lote')->nullable();
            $table->integer('id_producto')->nullable()->index('id_producto');
            $table->date('fecha_produccion')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('cantidad_incial')->nullable();
            $table->integer('cantidad_disponible')->nullable();
            $table->integer('id_bodega')->nullable()->index('id_bodega');
            $table->integer('id_estado')->nullable()->index('id_estado');
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
        Schema::dropIfExists('tbl_lote');
    }
};
