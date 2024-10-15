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
        Schema::create('tbl_movimiento', function (Blueprint $table) {
            $table->integer('id_movimiento', true);
            $table->decimal('monto_movimiento', 10)->nullable();
            $table->date('fecha_movimiento')->nullable();
            $table->string('descripcion_movimiento')->nullable();
            $table->integer('id_tipoMovimiento')->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
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
        Schema::dropIfExists('tbl_movimiento');
    }
};
