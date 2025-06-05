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
        Schema::table('cotizacion_has_suelas', function (Blueprint $table) {
            $table->string('colorPiso')->nullable()->after('idSuela');
            $table->string('colorCuna')->nullable()->after('colorPiso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacion_has_suelas', function (Blueprint $table) {
            $table->dropColumn('colorPiso');
            $table->dropColumn('colorCuna');
        });
    }
};
