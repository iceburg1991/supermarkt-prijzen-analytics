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
        Schema::table('weekly_revenue_products', function (Blueprint $table) {
            $table->decimal('base_revenue', 12, 2)->default(0)->after('revenue_contribution');
            $table->decimal('bonus_revenue', 12, 2)->default(0)->after('base_revenue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weekly_revenue_products', function (Blueprint $table) {
            $table->dropColumn(['base_revenue', 'bonus_revenue']);
        });
    }
};
