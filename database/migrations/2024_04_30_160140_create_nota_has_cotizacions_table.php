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
        Schema::create('nota_has_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idNota')->unsigned();
            $table->bigInteger('idCotizacion')->unsigned();
            $table->timestamps();

            $table->foreign('idNota')->references('id')->on('notas')->onDelete('cascade');
            $table->foreign('idCotizacion')->references('id')->on('cotizaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_has_cotizacions');
    }
};
