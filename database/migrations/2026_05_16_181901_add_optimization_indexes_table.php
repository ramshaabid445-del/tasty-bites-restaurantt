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
        // 1. Orders Table Optimization
        Schema::table('orders', function (Blueprint $table) {
            if (!$this->hasIndex('orders', 'orders_customer_phone_index')) {
                $table->index('customer_phone');
            }
            if (!$this->hasIndex('orders', 'orders_order_type_index')) {
                $table->index('order_type');
            }
            if (!$this->hasIndex('orders', 'orders_status_index')) {
                $table->index('status');
            }
            if (!$this->hasIndex('orders', 'orders_payment_method_index')) {
                $table->index('payment_method');
            }
            if (!$this->hasIndex('orders', 'orders_payment_status_index')) {
                $table->index('payment_status');
            }
            if (!$this->hasIndex('orders', 'orders_created_at_status_index')) {
                $table->index(['created_at', 'status']);
            }
        });

        // 2. Expenses Table Optimization
        Schema::table('expenses', function (Blueprint $table) {
            if (!$this->hasIndex('expenses', 'expenses_expense_date_index')) {
                $table->index('expense_date');
            }
            if (!$this->hasIndex('expenses', 'expenses_category_index')) {
                $table->index('category');
            }
        });

        // 3. Customers Table Optimization
        Schema::table('customers', function (Blueprint $table) {
            if (!$this->hasIndex('customers', 'customers_phone_index')) {
                $table->index('phone');
            }
        });

        // 4. Order Items Table Optimization
        Schema::table('order_items', function (Blueprint $table) {
            if (!$this->hasIndex('order_items', 'order_items_order_id_index')) {
                $table->index('order_id');
            }
            if (!$this->hasIndex('order_items', 'order_items_menu_item_id_index')) {
                $table->index('menu_item_id');
            }
        });

        // 5. Menu Items Table Optimization
        Schema::table('menu_items', function (Blueprint $table) {
            if (!$this->hasIndex('menu_items', 'menu_items_category_id_index')) {
                $table->index('category_id');
            }
            if (!$this->hasIndex('menu_items', 'menu_items_is_available_index')) {
                $table->index('is_available');
            }
            if (!$this->hasIndex('menu_items', 'menu_items_is_featured_index')) {
                $table->index('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Down method can be kept clean or empty since we are safely checking up migrations
    }

    /**
     * Helper function using Laravel's Native Schema Manager
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        $indexes = Schema::getIndexes($table);
        
        foreach ($indexes as $index) {
            if ($index['name'] === $indexName) {
                return true;
            }
        }
        
        return false;
    }
};