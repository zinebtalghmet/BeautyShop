<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('uses_variants')->default(false)->after('is_active');
            $table->integer('low_stock_threshold')->default(5)->after('uses_variants');
            $table->string('sku', 100)->nullable()->unique()->after('low_stock_threshold');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['uses_variants', 'low_stock_threshold', 'sku']);
        });
    }
};
