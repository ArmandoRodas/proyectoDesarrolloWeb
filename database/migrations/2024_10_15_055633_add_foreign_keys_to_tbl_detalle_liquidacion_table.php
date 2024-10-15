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
        Schema::table('tbl_detalle_liquidacion', function (Blueprint $table) {
            $table->foreign(['id_liquidacion'], 'tbl_detalle_liquidacion_ibfk_1')->references(['id_liquidacion'])->on('tbl_liquidaciones')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_gasto'], 'tbl_detalle_liquidacion_ibfk_2')->references(['id_gasto'])->on('tbl_gastos')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_detalle_liquidacion', function (Blueprint $table) {
            $table->dropForeign('tbl_detalle_liquidacion_ibfk_1');
            $table->dropForeign('tbl_detalle_liquidacion_ibfk_2');
        });
    }
};
