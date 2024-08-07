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
        Schema::create('cotizacion_has_costes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idCotizacion')->unsigned();
            $table->bigInteger('idCoste')->unsigned();
            $table->timestamps();

            $table->foreign('idCotizacion')->references('id')->on('cotizaciones')->onDelete('cascade');
            $table->foreign('idCoste')->references('id')->on('costes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_has_costes');
    }
};
