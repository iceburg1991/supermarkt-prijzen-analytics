<?php

namespace App\Models;

use Database\Factories\SalesTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property Carbon $transaction_date
 * @property int $quantity
 * @property numeric $unit_price
 * @property bool $is_promotion
 * @property string $receipt_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 *
 * @method static \Database\Factories\SalesTransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereIsPromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalesTransaction whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable(['product_id', 'transaction_date', 'quantity', 'unit_price', 'is_promotion', 'receipt_id'])]
class SalesTransaction extends Model
{
    /** @use HasFactory<SalesTransactionFactory> */
    use HasFactory;

    /**
     * Get the product associated with this transaction.
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
            'transaction_date' => 'date',
            'unit_price' => 'decimal:2',
            'is_promotion' => 'boolean',
        ];
    }
}
