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
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('colonia')->nullable()->after('ciudad');
            $table->string('calle')->nullable()->after('colonia');
            $table->string('exterior')->nullable()->after('calle');
            $table->string('cp')->nullable()->after('exterior');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('colonia');
            $table->dropColumn('calle');
            $table->dropColumn('exterior');
            $table->dropColumn('cp');
        });
    }
};
