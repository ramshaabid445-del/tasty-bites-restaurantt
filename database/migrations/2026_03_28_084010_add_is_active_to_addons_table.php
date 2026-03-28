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
    Schema::table('addons', function (Blueprint $table) {
        // Boolean column for active status
        $table->boolean('is_active')->default(true)->after('price');
    });
}

public function down(): void
{
    Schema::table('addons', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
}
};
