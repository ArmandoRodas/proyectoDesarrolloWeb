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
        Schema::create('tbl_lista_precio_producto', function (Blueprint $table) {
            $table->integer('id_lista_precio_producto', true);
            $table->integer('id_lista_precio')->nullable()->index('id_lista_precio');
            $table->integer('id_producto')->nullable()->index('id_producto');
            $table->decimal('precio_producto', 10)->nullable();
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
        Schema::dropIfExists('tbl_lista_precio_producto');
    }
};
