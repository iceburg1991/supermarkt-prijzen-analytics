<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevenueRequest;
use App\Http\Resources\RevenueResource;
use App\Services\RevenueService;

class RevenueController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private RevenueService $revenueService,
    ) {}

    /**
     * Return weekly revenue data in Highcharts-compatible format.
     */
    public function index(RevenueRequest $request): RevenueResource
    {
        $data = $this->revenueService->getWeeklyRevenue(
            weeks: $request->integer('weeks', 52),
        );

        return new RevenueResource($data);
    }
}
