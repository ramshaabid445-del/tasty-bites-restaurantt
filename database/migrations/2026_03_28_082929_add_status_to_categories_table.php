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
    Schema::table('categories', function (Blueprint $table) {
        // status column add kar rahe hain (1 = Active, 0 = Inactive)
        $table->tinyInteger('status')->default(1)->after('description');
    });
}

public function down(): void
{
    Schema::table('categories', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
