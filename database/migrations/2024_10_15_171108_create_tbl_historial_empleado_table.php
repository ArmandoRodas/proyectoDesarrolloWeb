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
        Schema::create('tbl_historial_empleado', function (Blueprint $table) {
            $table->integer('id_historial', true);
            $table->integer('id_empleado')->nullable()->index('id_empleado');
            $table->integer('id_rol_anterior')->nullable()->index('id_rol_anterior');
            $table->integer('id_rol_nuevo')->nullable()->index('id_rol_nuevo');
            $table->date('fecha_cambio')->nullable();
            $table->integer('id_sucursal_anterior')->nullable()->index('id_sucursal_anterior');
            $table->integer('id_sucursal_nueva')->nullable()->index('id_sucursal_nueva');
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
        Schema::dropIfExists('tbl_historial_empleado');
    }
};
