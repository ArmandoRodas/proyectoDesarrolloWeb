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
        Schema::table('tbl_excepciones_asistencia', function (Blueprint $table) {
            $table->foreign(['id_empleado'], 'tbl_excepciones_asistencia_ibfk_1')->references(['id_empleado'])->on('tbl_empleado')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['aprobado_por'], 'tbl_excepciones_asistencia_ibfk_2')->references(['id_usuario'])->on('tbl_usuario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_estado'], 'tbl_excepciones_asistencia_ibfk_3')->references(['id_estado'])->on('tbl_estado')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_excepciones_asistencia', function (Blueprint $table) {
            $table->dropForeign('tbl_excepciones_asistencia_ibfk_1');
            $table->dropForeign('tbl_excepciones_asistencia_ibfk_2');
            $table->dropForeign('tbl_excepciones_asistencia_ibfk_3');
        });
    }
};
