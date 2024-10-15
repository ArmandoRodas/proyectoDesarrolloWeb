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
        Schema::table('tbl_municipio', function (Blueprint $table) {
            $table->foreign(['id_departamento'], 'tbl_municipio_ibfk_1')->references(['id_departamento'])->on('tbl_departamento')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_municipio', function (Blueprint $table) {
            $table->dropForeign('tbl_municipio_ibfk_1');
        });
    }
};
