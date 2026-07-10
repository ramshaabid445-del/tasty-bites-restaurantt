<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Older local schema has created_at as an invalid zero-date default.
        // MySQL re-validates it on any ALTER TABLE, so normalize it first.
        DB::statement('ALTER TABLE `orders` MODIFY `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_phone');
            }

            if (! Schema::hasColumn('orders', 'customer_address')) {
                $table->text('customer_address')->nullable()->after('customer_email');
            }

            if (! Schema::hasColumn('orders', 'estimated_ready_at')) {
                $table->timestamp('estimated_ready_at')->nullable()->after('ready_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach (['estimated_ready_at', 'customer_address', 'customer_email'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
