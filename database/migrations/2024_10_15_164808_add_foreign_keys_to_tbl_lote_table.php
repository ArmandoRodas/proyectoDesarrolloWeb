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
        Schema::table('tbl_lote', function (Blueprint $table) {
            $table->foreign(['id_producto'], 'tbl_lote_ibfk_1')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_bodega'], 'tbl_lote_ibfk_2')->references(['id_bodega'])->on('tbl_bodega')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_estado'], 'tbl_lote_ibfk_3')->references(['id_estado'])->on('tbl_estado')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal'], 'tbl_lote_ibfk_4')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_lote', function (Blueprint $table) {
            $table->dropForeign('tbl_lote_ibfk_1');
            $table->dropForeign('tbl_lote_ibfk_2');
            $table->dropForeign('tbl_lote_ibfk_3');
            $table->dropForeign('tbl_lote_ibfk_4');
        });
    }
};
