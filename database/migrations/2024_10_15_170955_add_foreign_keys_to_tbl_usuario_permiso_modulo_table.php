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
        Schema::table('tbl_usuario_permiso_modulo', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'tbl_usuario_permiso_modulo_ibfk_1')->references(['id_usuario'])->on('tbl_usuario')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_permiso'], 'tbl_usuario_permiso_modulo_ibfk_2')->references(['id_permiso'])->on('tbl_permiso')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_modulo'], 'tbl_usuario_permiso_modulo_ibfk_3')->references(['id_modulo'])->on('tbl_modulo')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_usuario_permiso_modulo', function (Blueprint $table) {
            $table->dropForeign('tbl_usuario_permiso_modulo_ibfk_1');
            $table->dropForeign('tbl_usuario_permiso_modulo_ibfk_2');
            $table->dropForeign('tbl_usuario_permiso_modulo_ibfk_3');
        });
    }
};
