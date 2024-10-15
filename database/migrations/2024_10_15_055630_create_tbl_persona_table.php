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
        Schema::create('tbl_persona', function (Blueprint $table) {
            $table->integer('id_persona', true);
            $table->string('codigo_persona')->nullable();
            $table->string('nombre_persona')->nullable();
            $table->string('direccion_persona')->nullable();
            $table->string('telefono_persona')->nullable();
            $table->string('correo_persona')->nullable();
            $table->string('nit_persona')->nullable();
            $table->string('cui_persona')->nullable();
            $table->integer('id_tipo_persona')->nullable()->index('id_tipo_persona');
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
        Schema::dropIfExists('tbl_persona');
    }
};
