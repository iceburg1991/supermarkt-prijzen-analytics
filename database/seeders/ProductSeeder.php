<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Coca Cola Regular 1.5L', 'sku' => 'SKU-CC-REG-150', 'image_path' => 'coca-cola-regular-150.png'],
            ['name' => 'Coca Cola Zero 1.5L', 'sku' => 'SKU-CC-ZRO-150', 'image_path' => 'coca-cola-zero-150.png'],
            ['name' => 'Fanta 1.5L', 'sku' => 'SKU-FN-REG-150', 'image_path' => 'fanta-150.png'],
            ['name' => 'Fanta Zero Sugar 1.5L', 'sku' => 'SKU-FN-ZRO-150', 'image_path' => 'fanta-zero-sugar-150.png'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['sku' => $product['sku']], $product);
        }
    }
}
