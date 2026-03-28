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
    Schema::table('menu_items', function (Blueprint $table) {
        // Status column add ho raha hai (1 = Active/Available, 0 = Out of Stock)
        $table->tinyInteger('status')->default(1)->after('price');
    });
}

public function down(): void
{
    Schema::table('menu_items', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
