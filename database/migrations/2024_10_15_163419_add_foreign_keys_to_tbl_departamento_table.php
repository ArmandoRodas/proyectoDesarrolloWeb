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
        Schema::table('tbl_departamento', function (Blueprint $table) {
            $table->foreign(['id_pais'], 'tbl_departamento_ibfk_1')->references(['id_pais'])->on('tbl_pais')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_departamento', function (Blueprint $table) {
            $table->dropForeign('tbl_departamento_ibfk_1');
        });
    }
};
