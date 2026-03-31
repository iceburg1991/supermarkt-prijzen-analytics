<?php

namespace App\Models;

use Database\Factories\WeeklyRevenueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['week_start', 'week_number', 'year', 'base_revenue', 'bonus_revenue'])]
class WeeklyRevenue extends Model
{
    /** @use HasFactory<WeeklyRevenueFactory> */
    use HasFactory;

    /**
     * Get the product details for this weekly revenue.
     */
    public function products(): HasMany
    {
        return $this->hasMany(WeeklyRevenueProduct::class);
    }

    /**
     * Get the total revenue (base + bonus).
     */
    public function totalRevenue(): float
    {
        return (float) $this->base_revenue + (float) $this->bonus_revenue;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'week_start' => 'date',
            'base_revenue' => 'decimal:2',
            'bonus_revenue' => 'decimal:2',
        ];
    }
}
