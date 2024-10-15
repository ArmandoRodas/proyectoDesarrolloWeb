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
            $table->integer('id_metodo_pago')->nullable()->index('id_metodo_pago');
            $table->decimal('monto_det_apertura_caja', 10)->nullable();
            $table->date('fecha_det_apertura_caja')->nullable();
            $table->string('descripcion')->nullable();
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
