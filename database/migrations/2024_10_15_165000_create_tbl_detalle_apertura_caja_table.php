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
        Schema::create('tbl_detalle_apertura_caja', function (Blueprint $table) {
            $table->integer('id_det_apertura_caja', true);
            $table->integer('id_apertura_caja')->nullable()->index('id_apertura_caja');
            $table->string('tipo_movimiento')->nullable(); // ingreso o egreso
            $table->decimal('monto_det_apertura_caja', 10)->nullable();
            $table->string('descripcion_movimiento')->nullable();
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
        Schema::dropIfExists('tbl_detalle_apertura_caja');
    }
};
