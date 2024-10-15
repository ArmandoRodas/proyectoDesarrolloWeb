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
        Schema::table('tbl_lista_precio_producto', function (Blueprint $table) {
            $table->foreign(['id_lista_precio'], 'tbl_lista_precio_producto_ibfk_1')->references(['id_lista_precio'])->on('tbl_lista_precio')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_producto'], 'tbl_lista_precio_producto_ibfk_2')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_lista_precio_producto', function (Blueprint $table) {
            $table->dropForeign('tbl_lista_precio_producto_ibfk_1');
            $table->dropForeign('tbl_lista_precio_producto_ibfk_2');
        });
    }
};
