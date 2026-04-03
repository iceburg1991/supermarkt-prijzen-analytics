<?php

namespace Tests\Feature\Api;

use App\Models\WeeklyRevenue;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class RevenueEndpointTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * GET /api/revenue returns a 200 status code.
     */
    public function test_revenue_endpoint_returns200(): void
    {
        $response = $this->getJson('/api/revenue');

        $response->assertOk();
    }

    /**
     * Without a weeks parameter, the default of 52 weeks is used.
     * Records within the last 52 weeks should be returned.
     */
    public function test_revenue_endpoint_with_default_weeks(): void
    {
        // Create a record within the last 52 weeks
        $recentDate = now()->subWeeks(10)->startOfWeek();
        WeeklyRevenue::factory()->create([
            'week_start' => $recentDate,
            'week_number' => (int) $recentDate->format('W'),
            'year' => (int) $recentDate->format('o'),
            'base_revenue' => 15000.00,
            'bonus_revenue' => 3000.00,
        ]);

        // Create a record older than 52 weeks (should be excluded)
        $oldDate = now()->subWeeks(60)->startOfWeek();
        WeeklyRevenue::factory()->create([
            'week_start' => $oldDate,
            'week_number' => (int) $oldDate->format('W'),
            'year' => (int) $oldDate->format('o'),
            'base_revenue' => 99999.00,
            'bonus_revenue' => 88888.00,
        ]);

        $response = $this->getJson('/api/revenue');

        $response->assertOk()
            ->assertJsonCount(1, 'data.categories')
            ->assertJsonCount(1, 'data.series.0.data')
            ->assertJsonCount(1, 'data.series.1.data');
    }

    /**
     * Invalid weeks values (non-integer, out of range) return 422.
     */
    public function test_revenue_endpoint_rejects_invalid_weeks(): void
    {
        // Non-integer value
        $this->getJson('/api/revenue?weeks=abc')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('weeks');

        // Exceeds maximum of 104
        $this->getJson('/api/revenue?weeks=999')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('weeks');

        // Below minimum of 1
        $this->getJson('/api/revenue?weeks=0')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('weeks');

        // Negative value
        $this->getJson('/api/revenue?weeks=-5')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('weeks');
    }

    /**
     * An empty database returns empty categories and series arrays.
     */
    public function test_revenue_endpoint_with_empty_database(): void
    {
        $response = $this->getJson('/api/revenue');

        $response->assertOk()
            ->assertJsonPath('data.categories', [])
            ->assertJsonPath('data.series.0.data', [])
            ->assertJsonPath('data.series.1.data', []);
    }
}
