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
    Schema::create('dining_tables', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., "Table 1", "Window Table 3"
        $table->integer('capacity')->default(2); // Kitne log baith sakte hain
        $table->enum('status', ['available', 'occupied', 'reserved'])->default('available');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dining_tables');
    }
};
