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
        Schema::create('weekly_revenue_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_revenue_id')->constrained('weekly_revenue')->restrictOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedTinyInteger('week_number');
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('quantity');
            $table->decimal('revenue_contribution', 12, 2);
            $table->timestamps();

            $table->unique(['weekly_revenue_id', 'product_id']);
            $table->index(['year', 'week_number']);
            $table->index(['product_id', 'year', 'week_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_revenue_products');
    }
};
