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
        Schema::create('tbl_usuario', function (Blueprint $table) {
            $table->integer('id_usuario', true);
            $table->string('nombre_usuario')->nullable();
            $table->string('email_usuario')->nullable();
            $table->string('password')->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->string('direccion_usuario')->nullable();
            $table->date('fecha_actualizacion_usuario')->nullable();
            $table->string('telefono_usuario')->nullable();
            $table->integer('id_rol')->nullable()->index('id_rol');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_usuario');
    }
};
