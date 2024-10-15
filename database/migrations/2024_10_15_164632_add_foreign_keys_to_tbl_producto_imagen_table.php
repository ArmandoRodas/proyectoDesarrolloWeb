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
        Schema::table('tbl_producto_imagen', function (Blueprint $table) {
            $table->foreign(['id_producto'], 'tbl_producto_imagen_ibfk_1')->references(['id_producto'])->on('tbl_producto')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_producto_imagen', function (Blueprint $table) {
            $table->dropForeign('tbl_producto_imagen_ibfk_1');
        });
    }
};
