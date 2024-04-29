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
        Schema::table('notas', function (Blueprint $table) {
            $table->dropForeign(['idModelo']);
            $table->dropColumn('idModelo');

            $table->bigInteger('idCliente')->unsigned()->after('id');
            $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->dropForeign(['idCliente']);
            $table->dropColumn('idCliente');
        });
    }
};
