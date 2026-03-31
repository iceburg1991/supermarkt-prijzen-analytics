<?php

namespace App\Models;

use Database\Factories\WeeklyRevenueProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['weekly_revenue_id', 'product_id', 'week_number', 'year', 'quantity', 'revenue_contribution'])]
class WeeklyRevenueProduct extends Model
{
    /** @use HasFactory<WeeklyRevenueProductFactory> */
    use HasFactory;

    /**
     * Get the weekly revenue record this product detail belongs to.
     */
    public function weeklyRevenue(): BelongsTo
    {
        return $this->belongsTo(WeeklyRevenue::class);
    }

    /**
     * Get the product associated with this detail.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'revenue_contribution' => 'decimal:2',
        ];
    }
}
