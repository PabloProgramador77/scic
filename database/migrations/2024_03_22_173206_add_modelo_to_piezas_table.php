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
        Schema::table('piezas', function (Blueprint $table) {
            $table->bigInteger('idModelo')->unsigned()->nullable()->after('descripcion');
            $table->bigInteger('cantidad')->unsigned()->nullable()->after('idModelo');
            $table->foreign('idModelo')->references('id')->on('modelos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('piezas', function (Blueprint $table) {
            $table->dropForeign(['idModelo']);
            $table->dropColumn('idModelo');
        });
    }
};
