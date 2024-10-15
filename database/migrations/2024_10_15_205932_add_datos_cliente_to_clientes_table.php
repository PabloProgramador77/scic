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
            $table->dropColumn('domicilio');

            $table->string('numero')->nullable()->after('id');
            $table->string('estado')->nullable()->after('telefono');
            $table->string('ciudad')->nullable()->after('estado');
            $table->string('empresa')->nullable()->after('email');
            $table->string('razon')->nullable()->after('empresa');
            $table->string('rfc')->nullable()->after('razon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('numero');
            $table->dropColumn('estado');
            $table->dropColumn('ciudad');
            $table->dropColumn('empresa');
            $table->dropColumn('razon');
            $table->dropColumn('rfc');

            $table->string('domicilio')->nullable()->after('telefono');
        });
    }
};
