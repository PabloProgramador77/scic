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
        Schema::create('cotizacion_has_suelas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idCotizacion')->unsigned();
            $table->bigInteger('idSuela')->unsigned();
            $table->timestamps();

            $table->foreign('idCotizacion')->references('id')->on('cotizaciones')->onDelete('cascade');
            $table->foreign('idSuela')->references('id')->on('suelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_has_suelas');
    }
};
