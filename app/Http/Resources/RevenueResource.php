<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
{
    /**
     * Create a new resource instance wrapping a Collection.
     */
    public function __construct(private Collection $collection)
    {
        parent::__construct($collection);
    }

    /**
     * Transform the resource into a Highcharts-compatible array.
     *
     * @return array{categories: list<string>, series: list<array{name: string, data: list<float>}>}
     */
    public function toArray(Request $request): array
    {
        if ($this->collection->isEmpty()) {
            return [
                'categories' => [],
                'weekStarts' => [],
                'series' => [
                    ['name' => __('revenue.base_revenue'), 'data' => []],
                    ['name' => __('revenue.bonus_revenue'), 'data' => []],
                ],
            ];
        }

        $categories = [];
        $weekStarts = [];
        $baseData = [];
        $bonusData = [];

        foreach ($this->collection as $record) {
            $categories[] = sprintf('W%02d %d', $record->week_number, $record->year);
            $weekStarts[] = $record->week_start->format('d-m-Y');
            $baseData[] = (float) $record->base_revenue;
            $bonusData[] = (float) $record->bonus_revenue;
        }

        return [
            'categories' => $categories,
            'weekStarts' => $weekStarts,
            'series' => [
                ['name' => __('revenue.base_revenue'), 'data' => $baseData],
                ['name' => __('revenue.bonus_revenue'), 'data' => $bonusData],
            ],
        ];
    }
}
