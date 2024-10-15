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
        Schema::table('tbl_compra_detalle', function (Blueprint $table) {
            $table->foreign(['id_compra'], 'tbl_compra_detalle_ibfk_1')->references(['id_compra'])->on('tbl_compra')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_lote'], 'tbl_compra_detalle_ibfk_2')->references(['id_lote'])->on('tbl_lote')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_compra_detalle', function (Blueprint $table) {
            $table->dropForeign('tbl_compra_detalle_ibfk_1');
            $table->dropForeign('tbl_compra_detalle_ibfk_2');
        });
    }
};
