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
        Schema::create('tbl_departamento', function (Blueprint $table) {
            $table->id('id_departamento');
            $table->string('nombre_departamento', 255);
            $table->unsignedBigInteger('id_pais');

            // Foreign Key
            $table->foreign('id_pais')->references('id_pais')->on('tbl_pais')->onDelete('cascade');

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
        Schema::dropIfExists('tbl_departamento');
    }
};
