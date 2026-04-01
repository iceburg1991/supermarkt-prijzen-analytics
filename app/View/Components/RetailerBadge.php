<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Retailer badge component with brand-specific colors.
 *
 * Displays the retailer name in a colored badge matching
 * the retailer's brand identity.
 */
class RetailerBadge extends Component
{
    /**
     * Retailer color mapping.
     *
     * @var array<string, array{bg: string, text: string}>
     */
    private const COLORS = [
        'albert heijn' => ['bg' => '#60a5fa', 'text' => '#ffffff'],  // blue-400
        'appie' => ['bg' => '#60a5fa', 'text' => '#ffffff'],
        'ah' => ['bg' => '#60a5fa', 'text' => '#ffffff'],
        'hoogvliet' => ['bg' => '#7dd3fc', 'text' => '#1e3a5f'],     // sky-300 with dark text
        'deen' => ['bg' => '#f87171', 'text' => '#ffffff'],          // red-400
        'jumbo' => ['bg' => '#fcd34d', 'text' => '#78350f'],         // amber-300 with brown text
        'plus' => ['bg' => '#4ade80', 'text' => '#14532d'],          // green-400 with dark text
        'lidl' => ['bg' => '#818cf8', 'text' => '#ffffff'],          // indigo-400
        'aldi' => ['bg' => '#67e8f9', 'text' => '#164e63'],          // cyan-300 with dark text
        'dirk' => ['bg' => '#fb7185', 'text' => '#ffffff'],          // rose-400
        'coop' => ['bg' => '#fdba74', 'text' => '#7c2d12'],          // orange-300 with dark text
    ];

    /**
     * Default colors for unknown retailers.
     */
    private const DEFAULT_COLORS = ['bg' => '#6b7280', 'text' => '#ffffff'];

    public string $bgColor;

    public string $textColor;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $retailer,
    ) {
        $colors = $this->getColors($retailer);
        $this->bgColor = $colors['bg'];
        $this->textColor = $colors['text'];
    }

    /**
     * Get colors for a retailer name.
     *
     * @return array{bg: string, text: string}
     */
    private function getColors(string $retailer): array
    {
        $normalized = strtolower(trim($retailer));

        // Check for exact match first
        if (isset(self::COLORS[$normalized])) {
            return self::COLORS[$normalized];
        }

        // Check if retailer name starts with a known brand
        foreach (self::COLORS as $brand => $colors) {
            if (str_starts_with($normalized, $brand)) {
                return $colors;
            }
        }

        return self::DEFAULT_COLORS;
    }

    /**
     * Get the view that represents the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.retailer-badge');
    }
}
