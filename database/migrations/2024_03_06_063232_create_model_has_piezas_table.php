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
        Schema::create('model_has_piezas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idModelo')->unsigned();
            $table->bigInteger('idPieza')->unsigned();
            $table->bigInteger('cantidad')->unsigned();
            $table->timestamps();

            $table->foreign('idModelo')->references('id')->on('modelos')->onDelete('cascade');
            $table->foreign('idPieza')->references('id')->on('piezas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_piezas');
    }
};
