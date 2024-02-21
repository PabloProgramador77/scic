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
        Schema::create('piezas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('alto', 10, 2);
            $table->decimal('largo', 10, 2);
            $table->string('descripcion')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->decimal('cm2', 10, 2)->nullable();
            $table->decimal('dm2', 10, 2)->nullable();
            $table->decimal('mts', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piezas');
    }
};
