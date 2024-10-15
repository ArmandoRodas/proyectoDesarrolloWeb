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
        Schema::table('tbl_bodega_producto', function (Blueprint $table) {
            $table->foreign(['id_bodega'], 'tbl_bodega_producto_ibfk_1')->references(['id_bodega'])->on('tbl_bodega')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_producto'], 'tbl_bodega_producto_ibfk_2')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_bodega_producto', function (Blueprint $table) {
            $table->dropForeign('tbl_bodega_producto_ibfk_1');
            $table->dropForeign('tbl_bodega_producto_ibfk_2');
        });
    }
};
