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
        Schema::create('tbl_municipio', function (Blueprint $table) {
            $table->id('id_municipio');
            $table->string('nombre_municipio', 255);
            $table->unsignedBigInteger('id_departamento');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_departamento')->references('id')->on('tbl_departamento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_municipio');
    }
};
