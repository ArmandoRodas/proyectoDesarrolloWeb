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
        Schema::table('tbl_historial_producto', function (Blueprint $table) {
            $table->foreign(['id_producto'], 'tbl_historial_producto_ibfk_1')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario'], 'tbl_historial_producto_ibfk_2')->references(['id_usuario'])->on('tbl_usuario')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_historial_producto', function (Blueprint $table) {
            $table->dropForeign('tbl_historial_producto_ibfk_1');
            $table->dropForeign('tbl_historial_producto_ibfk_2');
        });
    }
};
