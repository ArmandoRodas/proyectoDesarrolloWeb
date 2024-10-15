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
            $table->integer('id_cliente')->nullable()->index('id_cliente');
            $table->decimal('monto_cxc', 10)->nullable();
            $table->date('fecha_emision_cxc')->nullable();
            $table->date('fecha_vencimiento_cxc')->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
            $table->string('descripcion_cxc')->nullable();
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
