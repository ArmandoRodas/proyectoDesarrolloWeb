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
        Schema::table('tbl_imagen_cxp', function (Blueprint $table) {
            $table->foreign(['id_historial_cxp'], 'tbl_imagen_cxp_ibfk_1')->references(['id_historial_cxp'])->on('tbl_historial_cxp')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_imagen_cxp', function (Blueprint $table) {
            $table->dropForeign('tbl_imagen_cxp_ibfk_1');
        });
    }
};
