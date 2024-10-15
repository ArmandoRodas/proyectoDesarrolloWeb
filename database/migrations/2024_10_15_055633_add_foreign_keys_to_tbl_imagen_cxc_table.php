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
        Schema::table('tbl_imagen_cxc', function (Blueprint $table) {
            $table->foreign(['id_historial_cxc'], 'tbl_imagen_cxc_ibfk_1')->references(['id_historial_cxc'])->on('tbl_historial_cxc')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_imagen_cxc', function (Blueprint $table) {
            $table->dropForeign('tbl_imagen_cxc_ibfk_1');
        });
    }
};
