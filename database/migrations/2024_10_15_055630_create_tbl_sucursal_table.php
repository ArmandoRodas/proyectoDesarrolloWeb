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
        Schema::create('tbl_sucursal', function (Blueprint $table) {
            $table->integer('id_sucursal', true);
            $table->string('nombre_sucursal')->nullable();
            $table->integer('id_pais')->nullable()->index('id_pais');
            $table->integer('id_departamento')->nullable()->index('id_departamento');
            $table->integer('id_municipio')->nullable()->index('id_municipio');
            $table->string('telefono_sucursal')->nullable();
            $table->string('email_sucursal')->nullable();
            $table->integer('id_estado')->nullable()->index('id_estado');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
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
        Schema::dropIfExists('tbl_sucursal');
    }
};
