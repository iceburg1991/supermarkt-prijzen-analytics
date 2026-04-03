<?php

namespace Tests\Unit;

use App\Data\RevenueResult;
use App\Http\Resources\RevenueResource;
use App\Models\WeeklyRevenue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

class RevenueResourceTest extends TestCase
{
    /**
     * The resource transforms a collection into the correct Highcharts JSON shape.
     */
    public function test_resource_transforms_collection_to_highcharts_shape(): void
    {
        $records = new Collection([
            new WeeklyRevenue([
                'week_start' => '2025-03-10',
                'week_number' => 11,
                'year' => 2025,
                'base_revenue' => 15000.00,
                'bonus_revenue' => 1200.00,
            ]),
            new WeeklyRevenue([
                'week_start' => '2025-03-17',
                'week_number' => 12,
                'year' => 2025,
                'base_revenue' => 16500.00,
                'bonus_revenue' => 800.00,
            ]),
        ]);

        $result = new RevenueResult(data: $records, queryTimeMs: 1.0, cacheHit: false);
        $resource = new RevenueResource($result);
        $response = $resource->toArray(Request::create('/api/revenue'));

        // Verify top-level keys exist
        $this->assertArrayHasKey('categories', $response);
        $this->assertArrayHasKey('series', $response);
        $this->assertArrayHasKey('meta', $response);

        // Verify categories count matches records
        $this->assertCount(2, $response['categories']);

        // Verify two series exist (base and bonus)
        $this->assertCount(2, $response['series']);

        // Verify series data counts match categories
        $this->assertCount(2, $response['series'][0]['data']);
        $this->assertCount(2, $response['series'][1]['data']);

        // Verify data values match input
        $this->assertSame(15000.0, $response['series'][0]['data'][0]);
        $this->assertSame(16500.0, $response['series'][0]['data'][1]);
        $this->assertSame(1200.0, $response['series'][1]['data'][0]);
        $this->assertSame(800.0, $response['series'][1]['data'][1]);
    }

    /**
     * An empty collection produces empty arrays for categories and series data.
     */
    public function test_resource_handles_empty_collection(): void
    {
        $result = new RevenueResult(data: new Collection, queryTimeMs: 0.5, cacheHit: true);
        $resource = new RevenueResource($result);
        $response = $resource->toArray(Request::create('/api/revenue'));

        $this->assertSame([], $response['categories']);
        $this->assertSame([], $response['series'][0]['data']);
        $this->assertSame([], $response['series'][1]['data']);
    }

    /**
     * Category labels follow the "W{nn} {yyyy}" format.
     */
    public function test_category_label_format(): void
    {
        $records = new Collection([
            new WeeklyRevenue([
                'week_start' => '2025-01-06',
                'week_number' => 2,
                'year' => 2025,
                'base_revenue' => 10000.00,
                'bonus_revenue' => 500.00,
            ]),
            new WeeklyRevenue([
                'week_start' => '2025-03-10',
                'week_number' => 11,
                'year' => 2025,
                'base_revenue' => 12000.00,
                'bonus_revenue' => 600.00,
            ]),
        ]);

        $result = new RevenueResult(data: $records, queryTimeMs: 1.0, cacheHit: false);
        $resource = new RevenueResource($result);
        $response = $resource->toArray(Request::create('/api/revenue'));

        // Week 2 should be zero-padded: "W02 2025"
        $this->assertSame('W02 2025', $response['categories'][0]);
        $this->assertSame('W11 2025', $response['categories'][1]);

        // Verify all labels match the pattern
        foreach ($response['categories'] as $label) {
            $this->assertMatchesRegularExpression('/^W\d{2} \d{4}$/', $label);
        }
    }
}
