<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Supermarket product brands.
     *
     * @var array<int, string>
     */
    private const BRANDS = [
        'Albert Heijn', 'Jumbo', 'Lidl', 'Aldi', 'Plus',
        'Heinz', 'Unox', 'Knorr', 'Maggi', 'Honig',
        'Douwe Egberts', 'Pickwick', 'Lipton', 'Nescafé',
        'Campina', 'Arla', 'Melkunie', 'Optimel',
        'Lay\'s', 'Doritos', 'Pringles', 'Croky',
        'Dr. Oetker', 'Wagner', 'Casa di Mama',
        'Calvé', 'Hellmann\'s', 'Remia', 'Gouda\'s Glorie',
        'Robijn', 'Persil', 'Dreft', 'Sun',
    ];

    /**
     * Supermarket product types.
     *
     * @var array<int, string>
     */
    private const TYPES = [
        'Melk', 'Kaas', 'Boter', 'Yoghurt', 'Vla',
        'Brood', 'Crackers', 'Beschuit', 'Ontbijtkoek',
        'Pasta', 'Rijst', 'Noodles', 'Couscous',
        'Koffie', 'Thee', 'Sap', 'Water', 'Limonade',
        'Chips', 'Noten', 'Koekjes', 'Chocolade', 'Snoep',
        'Soep', 'Saus', 'Ketchup', 'Mayonaise', 'Mosterd',
        'Pizza', 'Shoarma', 'Gehakt', 'Kip', 'Vis',
        'Wasmiddel', 'Afwasmiddel', 'Schoonmaak', 'Toiletpapier',
    ];

    /**
     * Product size variants.
     *
     * @var array<int, string>
     */
    private const SIZES = [
        '100g', '200g', '250g', '300g', '500g', '750g', '1kg',
        '100ml', '250ml', '330ml', '500ml', '750ml', '1L', '1.5L', '2L',
        '1 stuk', '2 stuks', '4 stuks', '6 stuks', '8 stuks', '10 stuks',
    ];

    /**
     * Dutch supermarket retailers.
     *
     * @var array<int, string>
     */
    private const RETAILERS = [
        'Albert Heijn', 'Jumbo', 'Lidl', 'Aldi', 'Plus',
        'Dirk', 'DekaMarkt', 'Coop', 'Spar', 'Vomar',
    ];

    /**
     * Define the model's default state.
     *
     * @return array{name: string, retailer: string, sku: string, image_path: string|null}
     */
    public function definition(): array
    {
        $brand = fake()->randomElement(self::BRANDS);
        $type = fake()->randomElement(self::TYPES);
        $size = fake()->randomElement(self::SIZES);

        return [
            'name' => "{$brand} {$type} {$size}",
            'retailer' => fake()->randomElement(self::RETAILERS),
            'sku' => fake()->unique()->numerify('SKU-######'),
            'image_path' => null,
        ];
    }
}
