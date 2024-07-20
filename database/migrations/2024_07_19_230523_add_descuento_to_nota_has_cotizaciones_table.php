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
            $table->decimal('descuento', 10, 2)->nullable()->after('monto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nota_has_cotizaciones', function (Blueprint $table) {
            $table->dropColumn('descuento');
        });
    }
};
