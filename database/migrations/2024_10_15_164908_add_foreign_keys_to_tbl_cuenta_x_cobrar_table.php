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
        Schema::table('tbl_cuenta_x_cobrar', function (Blueprint $table) {
            $table->foreign(['id_persona'], 'tbl_cuenta_x_cobrar_ibfk_1')->references(['id_persona'])->on('tbl_persona')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_estado'], 'tbl_cuenta_x_cobrar_ibfk_2')->references(['id_estado'])->on('tbl_estado')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal'], 'tbl_cuenta_x_cobrar_ibfk_3')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_venta'], 'tbl_cuenta_x_cobrar_ibfk_4')->references(['id_venta'])->on('tbl_venta')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_cuenta_x_cobrar', function (Blueprint $table) {
            $table->dropForeign('tbl_cuenta_x_cobrar_ibfk_1');
            $table->dropForeign('tbl_cuenta_x_cobrar_ibfk_2');
            $table->dropForeign('tbl_cuenta_x_cobrar_ibfk_3');
        });
    }
};
