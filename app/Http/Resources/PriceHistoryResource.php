<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceHistoryResource extends JsonResource
{
    /**
     * Create a new resource instance wrapping a Collection.
     */
    public function __construct(private Collection $collection)
    {
        parent::__construct($collection);
    }

    /**
     * Transform the resource into a Highcharts-compatible array for line chart.
     *
     * @return array{categories: list<string>, series: list<array{name: string, data: list<float>}>}
     */
    public function toArray(Request $request): array
    {
        if ($this->collection->isEmpty()) {
            return [
                'categories' => [],
                'weekNumbers' => [],
                'series' => [
                    ['name' => __('product.price'), 'data' => []],
                ],
            ];
        }

        $categories = [];
        $weekNumbers = [];
        $priceData = [];

        foreach ($this->collection as $record) {
            $categories[] = $record->changed_at->format('d-m-Y');
            $weekNumbers[] = 'W'.$record->changed_at->format('W').' '.$record->changed_at->format('Y');
            $priceData[] = (float) $record->price;
        }

        return [
            'categories' => $categories,
            'weekNumbers' => $weekNumbers,
            'series' => [
                ['name' => __('product.price'), 'data' => $priceData],
            ],
        ];
    }
}
