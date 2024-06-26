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
            $table->string('iva')->nullable()->after('estado');
            $table->decimal('envio', 10, 2)->nullable()->after('iva');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->dropColumn('iva');
            $table->dropColumn('envio');
        });
    }
};
