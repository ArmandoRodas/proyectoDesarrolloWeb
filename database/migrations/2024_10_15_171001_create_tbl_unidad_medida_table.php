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
        Schema::create('tbl_unidad_medida', function (Blueprint $table) {
            $table->integer('id_unidad_medida', true);
            $table->string('codigo_unidad_medida', 4)->nullable();
            $table->string('nombre_unidad_medida', 15)->nullable();
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
        Schema::dropIfExists('tbl_unidad_medida');
    }
};
