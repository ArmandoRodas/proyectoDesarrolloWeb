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
        Schema::table('tbl_empresa', function (Blueprint $table) {
            $table->foreign(['id_pais'], 'tbl_empresa_ibfk_1')->references(['id_pais'])->on('tbl_pais')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_departamento'], 'tbl_empresa_ibfk_2')->references(['id_departamento'])->on('tbl_departamento')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_municipio'], 'tbl_empresa_ibfk_3')->references(['id_municipio'])->on('tbl_municipio')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_estado'], 'tbl_empresa_ibfk_4')->references(['id'])->on('tbl_estado')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_empresa', function (Blueprint $table) {
            $table->dropForeign('tbl_empresa_ibfk_1');
            $table->dropForeign('tbl_empresa_ibfk_2');
            $table->dropForeign('tbl_empresa_ibfk_3');
            $table->dropForeign('tbl_empresa_ibfk_4');
        });
    }
};
