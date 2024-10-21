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
        Schema::table('tbl_conversion_producto', function (Blueprint $table) {
            $table->foreign(['id_producto_original'], 'tbl_conversion_producto_ibfk_1')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_producto_convertido'], 'tbl_conversion_producto_ibfk_2')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_empresa'], 'tbl_conversion_producto_ibfk_3')->references(['id_empresa'])->on('tbl_empresa')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal'], 'tbl_conversion_producto_ibfk_4')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_conversion_producto', function (Blueprint $table) {
            $table->dropForeign('tbl_conversion_producto_ibfk_1');
            $table->dropForeign('tbl_conversion_producto_ibfk_2');
            $table->dropForeign('tbl_conversion_producto_ibfk_3');
            $table->dropForeign('tbl_conversion_producto_ibfk_4');
        });
    }
};