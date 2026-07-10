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
        Schema::disableForeignKeyConstraints();

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Unique order ID (e.g., #ORD-00102)
            $table->string('order_number')->unique(); 
            $table->foreignId('user_id')->constrained('users');
            
            // Table link
            $table->foreignId('dining_table_id')->nullable()->constrained('dining_tables')->nullOnDelete();
            
            // NEW: Staff Assignment (HR management wale employees link honge)
            $table->foreignId('assigned_staff_id')->nullable()->constrained('employees')->nullOnDelete();

            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();

            // Order Type
            $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])->default('dine_in');
            
            // UPDATED STATUS: 'dispatched' add kar diya gaya hai error khatam karne ke liye
            $table->enum('status', [
                'pending', 
                'preparing', 
                'ready', 
                'delayed', 
                'dispatched', 
                'served', 
                'completed', 
                'cancelled'
            ])->default('pending');
            
            // Amounts
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0); 
            
            // Payment Info
            $table->enum('payment_method', ['cash', 'card', 'online', 'unpaid'])->default('unpaid');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            
            // Kitchen tracking ke liye timestamps
            $table->timestamp('preparing_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};