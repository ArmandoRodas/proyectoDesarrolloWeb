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
        Schema::create('tbl_lista_precio', function (Blueprint $table) {
            $table->integer('id_lista_precio', true);
            $table->string('nombre_lista_precio', 50);
            $table->string('descripcion_lista_precio', 100)->nullable();
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
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
        Schema::dropIfExists('tbl_lista_precio');
    }
};
