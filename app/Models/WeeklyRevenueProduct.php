<?php

namespace App\Models;

use Database\Factories\WeeklyRevenueProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $weekly_revenue_id
 * @property int $product_id
 * @property int $week_number
 * @property int $year
 * @property Carbon $week_start
 * @property int $quantity
 * @property numeric $revenue_contribution
 * @property numeric $base_revenue
 * @property numeric $bonus_revenue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 * @property-read WeeklyRevenue $weeklyRevenue
 *
 * @method static \Database\Factories\WeeklyRevenueProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereBaseRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereBonusRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereRevenueContribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereWeekNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereWeekStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereWeeklyRevenueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenueProduct whereYear($value)
 *
 * @mixin \Eloquent
 */
#[Fillable(['weekly_revenue_id', 'product_id', 'week_number', 'year', 'week_start', 'quantity', 'revenue_contribution', 'base_revenue', 'bonus_revenue'])]
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
            'week_start' => 'date',
            'revenue_contribution' => 'decimal:2',
            'base_revenue' => 'decimal:2',
            'bonus_revenue' => 'decimal:2',
        ];
    }
}
