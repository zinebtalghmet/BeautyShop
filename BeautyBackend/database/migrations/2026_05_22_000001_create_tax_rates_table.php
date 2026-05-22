<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->string('country', 5);
            $table->string('region', 100)->nullable();
            $table->string('label', 100);
            $table->decimal('rate', 5, 2);
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['country', 'region']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
    }
};
