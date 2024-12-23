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
        Schema::create('tbl_imagen_cxp', function (Blueprint $table) {
            $table->integer('id_imagen_cxp', true);
            $table->integer('id_historial_cxp')->nullable()->index('id_historial_cxp');
            $table->string('url_imagen_cxp')->nullable();
            $table->string('descripcion_imagen_cxp')->nullable();
            $table->date('fecha_subida_imagen_cxp')->nullable();
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
        Schema::dropIfExists('tbl_imagen_cxp');
    }
};
