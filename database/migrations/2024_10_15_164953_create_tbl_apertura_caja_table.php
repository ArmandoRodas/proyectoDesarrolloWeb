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
        Schema::create('tbl_apertura_caja', function (Blueprint $table) {
            $table->integer('id_apertura_caja', true);
            $table->integer('id_caja')->nullable()->index('id_caja');
            $table->decimal('saldo_inicial_caja', 10)->nullable();
            $table->string('descripcion_apertura_caja', 75)->nullable();
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
        Schema::dropIfExists('tbl_apertura_caja');
    }
};
