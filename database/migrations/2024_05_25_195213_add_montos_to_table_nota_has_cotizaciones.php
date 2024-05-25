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
        Schema::table('nota_has_cotizaciones', function (Blueprint $table) {
            $table->bigInteger('totalPares')->unsigned()->after('idCotizacion');
            $table->decimal('monto', 10, 2)->after('totalPares');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nota_has_cotizaciones', function (Blueprint $table) {
            $table->dropColumn('totalPares');
            $table->dropColumn('monto');
        });
    }
};
