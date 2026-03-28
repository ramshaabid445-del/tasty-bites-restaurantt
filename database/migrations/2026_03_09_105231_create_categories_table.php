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
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique(); // URL ya search ke liye
        $table->string('image')->nullable();
        $table->text('description')->nullable(); // Ye line check karein
        $table->boolean('is_active')->default(true); // Category on/off karne ke liye
        $table->timestamps();
        $table->softDeletes(); // Record delete karne pe permanently delete nahi hoga (2026 SaaS standard)
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
