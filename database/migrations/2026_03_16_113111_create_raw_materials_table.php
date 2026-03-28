<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('raw_materials', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('unit'); // kg, gram, liter, pc
        $table->decimal('quantity', 10, 2)->default(0);
        $table->decimal('alert_quantity', 10, 2)->default(5); // Stock kam hone par alert
        $table->decimal('last_purchase_price', 10, 2)->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
