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
        Schema::table('tbl_venta', function (Blueprint $table) {
            $table->foreign(['id_tipo_documento'], 'tbl_venta_ibfk_1')->references(['id_documento'])->on('tbl_tipo_documento')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_medio_pago'], 'tbl_venta_ibfk_2')->references(['id_metodo_pago'])->on('tbl_metodo_pago')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_usuario'], 'tbl_venta_ibfk_3')->references(['id_usuario'])->on('tbl_usuario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_persona'], 'tbl_venta_ibfk_4')->references(['id_persona'])->on('tbl_persona')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_tipoVenta'], 'tbl_venta_ibfk_5')->references(['id_tipoVenta'])->on('tbl_tipo_venta')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_empresa'], 'tbl_venta_ibfk_6')->references(['id_empresa'])->on('tbl_empresa')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_sucursal'], 'tbl_venta_ibfk_7')->references(['id_sucursal'])->on('tbl_sucursal')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_venta', function (Blueprint $table) {
            $table->dropForeign('tbl_venta_ibfk_1');
            $table->dropForeign('tbl_venta_ibfk_2');
            $table->dropForeign('tbl_venta_ibfk_3');
            $table->dropForeign('tbl_venta_ibfk_4');
            $table->dropForeign('tbl_venta_ibfk_5');
            $table->dropForeign('tbl_venta_ibfk_6');
            $table->dropForeign('tbl_venta_ibfk_7');
        });
    }
};
