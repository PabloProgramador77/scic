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
            $table->bigInteger('idSuaje')->unsigned()->nullable()->after('cantidad');
            $table->foreign('idSuaje')->references('id')->on('suajes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('piezas', function (Blueprint $table) {
            $table->dropForeign(['idSuaje']);
            $table->dropColumn('idSuaje');
        });
    }
};
