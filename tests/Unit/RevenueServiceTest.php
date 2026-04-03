<?php

namespace Tests\Unit;

use App\Models\WeeklyRevenue;
use App\Services\RevenueService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RevenueServiceTest extends TestCase
{
    use LazilyRefreshDatabase;

    private RevenueService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new RevenueService;
    }

    /**
     * The service returns only the expected columns: week_number, year, base_revenue, bonus_revenue.
     */
    public function test_revenue_service_returns_correct_columns(): void
    {
        $date = now()->subWeeks(2)->startOfWeek();
        WeeklyRevenue::factory()->create([
            'week_start' => $date,
            'week_number' => (int) $date->format('W'),
            'year' => (int) $date->format('o'),
        ]);

        $result = $this->service->getWeeklyRevenue();
        $record = $result->data->first();

        $this->assertNotNull($record);
        $this->assertNotNull($record->week_number);
        $this->assertNotNull($record->year);
        $this->assertNotNull($record->base_revenue);
        $this->assertNotNull($record->bonus_revenue);
    }

    /**
     * Results are sorted by week_start in ascending (chronological) order.
     */
    public function test_revenue_service_returns_chronological_order(): void
    {
        // Create records in reverse chronological order
        $week10 = now()->subWeeks(10)->startOfWeek();
        $week5 = now()->subWeeks(5)->startOfWeek();
        $week2 = now()->subWeeks(2)->startOfWeek();

        WeeklyRevenue::factory()->create([
            'week_start' => $week2,
            'week_number' => (int) $week2->format('W'),
            'year' => (int) $week2->format('o'),
        ]);
        WeeklyRevenue::factory()->create([
            'week_start' => $week10,
            'week_number' => (int) $week10->format('W'),
            'year' => (int) $week10->format('o'),
        ]);
        WeeklyRevenue::factory()->create([
            'week_start' => $week5,
            'week_number' => (int) $week5->format('W'),
            'year' => (int) $week5->format('o'),
        ]);

        $result = $this->service->getWeeklyRevenue();
        $data = $result->data;

        $this->assertCount(3, $data);

        // Verify ascending order by comparing week_start dates
        $weekStarts = $data->pluck('week_start')->map(fn ($d) => $d->format('Y-m-d'))->toArray();
        $sorted = $weekStarts;
        sort($sorted);

        $this->assertSame($sorted, $weekStarts);
    }

    /**
     * An empty table returns an empty collection.
     */
    public function test_revenue_service_returns_empty_collection_when_no_data(): void
    {
        $result = $this->service->getWeeklyRevenue();

        $this->assertTrue($result->data->isEmpty());
    }
}
