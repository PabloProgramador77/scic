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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->bigInteger('orden')->unsigned();
            $table->string('tipo');
            $table->bigInteger('duracion')->unsigned();
            $table->bigInteger('idProceso')->unsigned();
            $table->bigInteger('idUsuario')->unsigned();
            $table->timestamps();

            $table->foreign('idProceso')->references('id')->on('procesos')->onDelete('cascade');
            $table->foreign('idUsuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividads');
    }
};
