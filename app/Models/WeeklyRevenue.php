<?php

namespace App\Models;

use Database\Factories\WeeklyRevenueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $week_start
 * @property int $week_number
 * @property int $year
 * @property numeric $base_revenue
 * @property numeric $bonus_revenue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, WeeklyRevenueProduct> $products
 * @property-read int|null $products_count
 *
 * @method static \Database\Factories\WeeklyRevenueFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereBaseRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereBonusRevenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereWeekNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereWeekStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeeklyRevenue whereYear($value)
 *
 * @mixin \Eloquent
 */
#[Fillable(['week_start', 'week_number', 'year', 'base_revenue', 'bonus_revenue'])]
class WeeklyRevenue extends Model
{
    /** @use HasFactory<WeeklyRevenueFactory> */
    use HasFactory;

    protected $fillable = [
        'week_start',
        'week_number',
        'year',
        'base_revenue',
        'bonus_revenue',
    ];

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
