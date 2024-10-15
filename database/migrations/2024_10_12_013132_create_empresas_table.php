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
            $table->id('id_empresa');
            $table->string('nombre_empresa', 255);
            $table->string('NIT_empresa', 10);
            $table->string('direccion_empresa', 255)->nullable();
            $table->string('telefono_empresa', 255)->nullable();
            $table->string('email_empresa', 255)->nullable();

            // Llaves foráneas
            $table->unsignedBigInteger('id_pais')->nullable();
            $table->unsignedBigInteger('id_departamento')->nullable();
            $table->unsignedBigInteger('id_municipio')->nullable();
            $table->unsignedBigInteger('id_estado')->nullable();

            // Foreign Keys
            $table->foreign('id_pais')->references('id')->on('tbl_pais')->onDelete('set null');
            $table->foreign('id_departamento')->references('id')->on('tbl_departamento')->onDelete('set null');
            $table->foreign('id_municipio')->references('id')->on('tbl_municipio')->onDelete('set null');
            $table->foreign('id_estado')->references('id')->on('tbl_estado')->onDelete('set null');

            // Campos de timestamps y soft deletes
            $table->timestamps();
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
