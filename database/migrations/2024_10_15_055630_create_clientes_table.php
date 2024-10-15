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
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_cliente');
            $table->string('nombre_cliente', 50);
            $table->string('nit_cliente', 15);
            $table->string('direccion_cliente', 75);
            $table->string('telefono_cliente', 15)->nullable();
            $table->string('correo_cliente', 50)->nullable();
            $table->string('cui_cliente', 15)->nullable();
            $table->tinyInteger('estado_cliente')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
