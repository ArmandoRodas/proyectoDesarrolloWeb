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
        Schema::create('tbl_empresa', function (Blueprint $table) {
            $table->integer('id_empresa', true);
            $table->string('nombre_empresa');
            $table->integer('NIT_empresa');
            $table->string('direccion_empresa')->nullable();
            $table->string('telefono_empresa')->nullable();
            $table->string('email_empresa')->nullable();
            $table->integer('id_pais')->nullable()->index('id_pais');
            $table->integer('id_departamento')->nullable()->index('id_departamento');
            $table->integer('id_municipio')->nullable()->index('id_municipio');
            $table->integer('id_estado')->nullable()->index('id_estado');
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
        Schema::dropIfExists('tbl_empresa');
    }
};
