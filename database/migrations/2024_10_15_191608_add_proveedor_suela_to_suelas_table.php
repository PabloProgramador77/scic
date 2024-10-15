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
        Schema::table('suelas', function (Blueprint $table) {
            $table->string('proveedor')->nullable()->after('precio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suelas', function (Blueprint $table) {
            $table->dropColumn('proveedor');
        });
    }
};
