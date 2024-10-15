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
        Schema::table('tbl_gastos', function (Blueprint $table) {
            $table->foreign(['id_caja'], 'tbl_gastos_ibfk_1')->references(['id_caja'])->on('tbl_caja')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario'], 'tbl_gastos_ibfk_2')->references(['id_usuario'])->on('tbl_usuario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal'], 'tbl_gastos_ibfk_3')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_empresa'], 'tbl_gastos_ibfk_4')->references(['id_empresa'])->on('tbl_empresa')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_estado'], 'tbl_gastos_ibfk_5')->references(['id'])->on('tbl_estado')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_gastos', function (Blueprint $table) {
            $table->dropForeign('tbl_gastos_ibfk_1');
            $table->dropForeign('tbl_gastos_ibfk_2');
            $table->dropForeign('tbl_gastos_ibfk_3');
            $table->dropForeign('tbl_gastos_ibfk_4');
            $table->dropForeign('tbl_gastos_ibfk_5');
        });
    }
};
