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
        Schema::create('tbl_liquidaciones', function (Blueprint $table) {
            $table->integer('id_liquidacion', true);
            $table->date('fecha_liquidacion')->nullable();
            $table->decimal('total_gastos', 10)->nullable();
            $table->decimal('monto_liquidado', 10)->nullable();
            $table->integer('id_caja')->nullable()->index('id_caja');
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
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
        Schema::dropIfExists('tbl_liquidaciones');
    }
};
