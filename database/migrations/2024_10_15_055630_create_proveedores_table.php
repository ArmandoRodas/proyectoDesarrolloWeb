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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_proveedor');
            $table->string('nombre_proveedor', 50);
            $table->string('nit_proveedor', 15);
            $table->string('direccion_proveedor', 75);
            $table->string('telefono_proveedor', 15)->nullable();
            $table->string('correo_proveedor', 50)->nullable();
            $table->string('cui_proveedor', 15)->nullable();
            $table->tinyInteger('estado_proveedor')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
