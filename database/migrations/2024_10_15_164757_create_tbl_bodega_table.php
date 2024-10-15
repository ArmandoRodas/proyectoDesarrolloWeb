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
        Schema::create('tbl_bodega', function (Blueprint $table) {
            $table->integer('id_bodega', true);
            $table->string('nombre_bodega')->nullable();
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
        Schema::dropIfExists('tbl_bodega');
    }
};
