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
        Schema::create('weekly_revenue', function (Blueprint $table) {
            $table->id();
            $table->date('week_start');
            $table->unsignedTinyInteger('week_number');
            $table->unsignedSmallInteger('year');
            $table->decimal('base_revenue', 12, 2);
            $table->decimal('bonus_revenue', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['year', 'week_number']);
            $table->index('week_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_revenue');
    }
};
