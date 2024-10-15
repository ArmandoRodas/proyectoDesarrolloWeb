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
        Schema::create('tbl_historial_producto', function (Blueprint $table) {
            $table->integer('id_historial', true);
            $table->integer('id_producto')->nullable()->index('id_producto');
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->integer('id_movimiento')->nullable();
            $table->date('fecha_historial')->nullable();
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
        Schema::dropIfExists('tbl_historial_producto');
    }
};
