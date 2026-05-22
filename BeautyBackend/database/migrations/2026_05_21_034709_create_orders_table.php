<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 50)->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('shipping_first_name', 100);
            $table->string('shipping_last_name', 100);
            $table->string('shipping_email', 100);
            $table->string('shipping_phone', 50)->nullable();
            $table->string('shipping_address', 255);
            $table->string('shipping_city', 100);
            $table->string('shipping_state', 100);
            $table->string('shipping_zip', 20);
            $table->string('shipping_country', 100)->default('USA');
            $table->string('payment_method', 50)->default('cod');
            $table->string('payment_status', 50)->default('pending');
            $table->string('tracking_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancelled_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
