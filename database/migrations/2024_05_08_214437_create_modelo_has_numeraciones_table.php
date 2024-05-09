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
        Schema::create('modelo_has_numeraciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idModelo')->unsigned();
            $table->bigInteger('idNumeracion')->unsigned();
            $table->timestamps();

            $table->foreign('idModelo')->references('id')->on('modelos')->onDelete('cascade');
            $table->foreign('idNumeracion')->references('id')->on('numeraciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelo_has_numeraciones');
    }
};
