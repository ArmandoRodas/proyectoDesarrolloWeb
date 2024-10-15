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
        Schema::create('tbl_empleado', function (Blueprint $table) {
            $table->integer('id_empleado', true);
            $table->integer('id_usuario')->nullable()->index('id_usuario');
            $table->integer('id_empresa')->nullable()->index('id_empresa');
            $table->integer('id_sucursal')->nullable()->index('id_sucursal');
            $table->integer('id_rol')->nullable()->index('id_rol');
            $table->string('nombre_empleado')->nullable();
            $table->string('apellido_empleado')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->decimal('salario', 10)->nullable();
            $table->string('puesto')->nullable();
            $table->string('direccion_empleado')->nullable();
            $table->string('telefono_empleado')->nullable();
            $table->string('email_empleado')->nullable();
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
        Schema::dropIfExists('tbl_empleado');
    }
};
