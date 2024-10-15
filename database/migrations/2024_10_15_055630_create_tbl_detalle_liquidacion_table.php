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
        Schema::create('tbl_detalle_liquidacion', function (Blueprint $table) {
            $table->integer('id_detalle_liquidacion', true);
            $table->integer('id_liquidacion')->nullable()->index('id_liquidacion');
            $table->integer('id_gasto')->nullable()->index('id_gasto');
            $table->decimal('monto_gasto', 10)->nullable();
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
        Schema::dropIfExists('tbl_detalle_liquidacion');
    }
};
