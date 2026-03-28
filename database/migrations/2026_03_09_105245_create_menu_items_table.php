<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            
            // Core Relations & Identity
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Pricing Logic (Decimal 10,2 is best for PKR/USD)
            $table->decimal('price', 10, 2); // Regular Price
            $table->decimal('discount_price', 10, 2)->nullable(); // Sale Price (Optional)
            $table->decimal('tax_percent', 5, 2)->default(0); // For GST calculations
            
            // Fast Food Specifics
            $table->string('image')->nullable();
            $table->integer('preparation_time')->nullable(); // Minutes mein (e.g., 15)
            $table->enum('type', ['veg', 'non-veg', 'beverage', 'dessert'])->default('non-veg');
            
            // Inventory & Status
            $table->boolean('is_available')->default(true); 
            $table->boolean('is_featured')->default(false); // For "Today's Special"
            $table->integer('stock_qty')->default(-1); // -1 means Unlimited, else tracking
            
            // Sorting & Auditing
            $table->integer('sort_order')->default(0); // Items ko ooper-neeche karne ke liye
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};