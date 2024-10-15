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
        Schema::table('tbl_venta_detalle', function (Blueprint $table) {
            $table->foreign(['id_venta'], 'tbl_venta_detalle_ibfk_1')->references(['id_venta'])->on('tbl_venta')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_producto'], 'tbl_venta_detalle_ibfk_2')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_lote'], 'tbl_venta_detalle_ibfk_3')->references(['id_lote'])->on('tbl_lote')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_venta_detalle', function (Blueprint $table) {
            $table->dropForeign('tbl_venta_detalle_ibfk_1');
            $table->dropForeign('tbl_venta_detalle_ibfk_2');
            $table->dropForeign('tbl_venta_detalle_ibfk_3');
        });
    }
};
