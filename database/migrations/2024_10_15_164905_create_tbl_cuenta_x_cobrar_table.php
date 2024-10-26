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
        Schema::create('tbl_cuenta_x_cobrar', function (Blueprint $table) {
            $table->integer('id_cxc', true);
            $table->integer('id_venta')->nullable()->index('id_venta');
            $table->integer('id_persona')->nullable()->index('id_persona');
            $table->integer('dias_credito')->nullable();
            $table->date('fecha_vencimiento_cxc')->nullable();
            $table->decimal('monto_cxc', 10)->nullable();
            $table->decimal('saldo_pendiente_cxc', 10)->nullable();
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
        Schema::dropIfExists('tbl_cuenta_x_cobrar');
    }
};
