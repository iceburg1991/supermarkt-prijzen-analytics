<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'retailer', 'sku', 'image_path'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * The base path for product images.
     */
    private const IMAGE_BASE_PATH = 'images/products';

    /**
     * Get the full public URL for the product image.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(
            fn (): ?string => $this->image_path
                ? asset(self::IMAGE_BASE_PATH.'/'.$this->image_path)
                : null
        );
    }

    /**
     * Get the sales transactions for this product.
     */
    public function salesTransactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class);
    }

    /**
     * Get the weekly revenue product details for this product.
     */
    public function weeklyRevenueProducts(): HasMany
    {
        return $this->hasMany(WeeklyRevenueProduct::class);
    }
}
