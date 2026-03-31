<?php

namespace App\Models;

use Database\Factories\SalesTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
