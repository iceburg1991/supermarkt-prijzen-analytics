<?php

namespace Tests\Unit;

use Tests\TestCase;

class RevenueTranslationTest extends TestCase
{
    /**
     * Required translation keys for the revenue feature.
     *
     * @var list<string>
     */
    private array $requiredKeys = [
        'revenue.chart_title',
        'revenue.base_revenue',
        'revenue.bonus_revenue',
        'revenue.filter_all',
        'revenue.filter_base',
        'revenue.filter_bonus',
        'revenue.y_axis_label',
        'revenue.tooltip_total',
        'revenue.tooltip_week',
        'revenue.architecture_intro',
        'revenue.architecture_dataset',
        'revenue.architecture_single_call',
        'revenue.architecture_client_filter',
        'revenue.architecture_scaling',
    ];

    /**
     * All required NL translation keys exist and return non-empty strings.
     */
    public function test_translation_keys_exist_for_nl(): void
    {
        app()->setLocale('nl');

        foreach ($this->requiredKeys as $key) {
            $translation = __($key);

            // Translation should not fall back to the key itself
            $this->assertNotSame($key, $translation, "Missing NL translation for: {$key}");
            $this->assertNotEmpty($translation, "Empty NL translation for: {$key}");
        }
    }

    /**
     * All required EN translation keys exist and return non-empty strings.
     */
    public function test_translation_keys_exist_for_en(): void
    {
        app()->setLocale('en');

        foreach ($this->requiredKeys as $key) {
            $translation = __($key);

            // Translation should not fall back to the key itself
            $this->assertNotSame($key, $translation, "Missing EN translation for: {$key}");
            $this->assertNotEmpty($translation, "Empty EN translation for: {$key}");
        }
    }
}
