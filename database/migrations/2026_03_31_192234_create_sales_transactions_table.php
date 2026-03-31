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
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->date('transaction_date');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->boolean('is_promotion')->default(false);
            $table->string('receipt_id');
            $table->timestamps();

            $table->index('transaction_date');
            $table->index('receipt_id');
            $table->index(['product_id', 'transaction_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};
