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
        Schema::create('tbl_venta', function (Blueprint $table) {
            $table->integer('id_venta', true);
            $table->string('documento_venta')->nullable();
            $table->decimal('total_venta', 10)->nullable();
            $table->date('fecha_venta')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->integer('id_tipo_documento')->nullable()->index('id_tipo_documento');
            $table->integer('id_medio_pago')->nullable()->index('id_medio_pago');
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->integer('id_persona')->nullable()->index('id_persona');
            $table->integer('id_tipoVenta')->nullable()->index('id_tipoventa');
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
        Schema::dropIfExists('tbl_venta');
    }
};
