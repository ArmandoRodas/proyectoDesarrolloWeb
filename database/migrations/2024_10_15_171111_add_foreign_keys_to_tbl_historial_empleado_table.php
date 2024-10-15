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
        Schema::table('tbl_historial_empleado', function (Blueprint $table) {
            $table->foreign(['id_empleado'], 'tbl_historial_empleado_ibfk_1')->references(['id_empleado'])->on('tbl_empleado')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_rol_anterior'], 'tbl_historial_empleado_ibfk_2')->references(['id_rol'])->on('tbl_rol')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_rol_nuevo'], 'tbl_historial_empleado_ibfk_3')->references(['id_rol'])->on('tbl_rol')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal_anterior'], 'tbl_historial_empleado_ibfk_4')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal_nueva'], 'tbl_historial_empleado_ibfk_5')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_historial_empleado', function (Blueprint $table) {
            $table->dropForeign('tbl_historial_empleado_ibfk_1');
            $table->dropForeign('tbl_historial_empleado_ibfk_2');
            $table->dropForeign('tbl_historial_empleado_ibfk_3');
            $table->dropForeign('tbl_historial_empleado_ibfk_4');
            $table->dropForeign('tbl_historial_empleado_ibfk_5');
        });
    }
};
