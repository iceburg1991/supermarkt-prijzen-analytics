<?php

namespace App\Http\Resources;

use App\Data\RevenueResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
{
    /**
     * Create a new resource instance wrapping a RevenueResult.
     */
    public function __construct(private RevenueResult $result)
    {
        parent::__construct($result);
    }

    /**
     * Transform the resource into a Highcharts-compatible array with performance meta.
     *
     * @return array{categories: list<string>, weekStarts: list<string>, series: list<array{name: string, data: list<float>}>, meta: array{query_time_ms: float, cache_hit: bool, source: string}}
     */
    public function toArray(Request $request): array
    {
        $collection = $this->result->data;

        if ($collection->isEmpty()) {
            return [
                'categories' => [],
                'weekStarts' => [],
                'series' => [
                    ['name' => __('revenue.base_revenue'), 'data' => []],
                    ['name' => __('revenue.bonus_revenue'), 'data' => []],
                ],
                'meta' => $this->buildMeta(),
            ];
        }

        $categories = [];
        $weekStarts = [];
        $baseData = [];
        $bonusData = [];

        foreach ($collection as $record) {
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
            'meta' => $this->buildMeta(),
        ];
    }

    /**
     * Build the performance meta array.
     *
     * @return array{query_time_ms: float, cache_hit: bool, source: string}
     */
    private function buildMeta(): array
    {
        return [
            'query_time_ms' => $this->result->queryTimeMs,
            'cache_hit' => $this->result->cacheHit,
            'source' => $this->result->cacheHit ? 'cache' : 'database',
        ];
    }
}
