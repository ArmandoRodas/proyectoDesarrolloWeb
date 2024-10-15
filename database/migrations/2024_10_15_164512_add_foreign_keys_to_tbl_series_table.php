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
        Schema::table('tbl_series', function (Blueprint $table) {
            $table->foreign(['id_documento'], 'tbl_series_ibfk_1')->references(['id_documento'])->on('tbl_tipo_documento')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_estado'], 'tbl_series_ibfk_2')->references(['id_estado'])->on('tbl_estado')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_series', function (Blueprint $table) {
            $table->dropForeign('tbl_series_ibfk_1');
            $table->dropForeign('tbl_series_ibfk_2');
        });
    }
};
