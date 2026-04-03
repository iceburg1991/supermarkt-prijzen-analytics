<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardChartTest extends TestCase
{
    /**
     * The dashboard chart page loads successfully.
     */
    public function test_dashboard_chart_page_loads(): void
    {
        $response = $this->get('/grafiek');

        $response->assertOk();
    }

    /**
     * The chart view receives the locale variable.
     */
    public function test_dashboard_chart_passes_locale(): void
    {
        $response = $this->get('/grafiek');

        $response->assertOk()
            ->assertViewHas('locale', app()->getLocale());
    }
}
