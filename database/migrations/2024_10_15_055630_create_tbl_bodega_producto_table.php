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
        Schema::create('tbl_bodega_producto', function (Blueprint $table) {
            $table->integer('id_bodega')->nullable()->index('id_bodega');
            $table->integer('id_producto')->nullable()->index('id_producto');
            $table->integer('stock_producto')->nullable();
            $table->integer('stock_min_producto')->nullable();
            $table->integer('stock_max_producto')->nullable();
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
        Schema::dropIfExists('tbl_bodega_producto');
    }
};
