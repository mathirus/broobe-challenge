<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchMetricsRequest;
use App\Http\Requests\SaveMetricsRequest;
use App\Models\Strategy;
use App\Services\GooglePageSpeedService;
use App\Services\MetricHistoryRunService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\HandlesLogging;
use Illuminate\Support\Facades\Lang;

class MetricHistoryRunController extends Controller
{
    use HandlesLogging;

    protected $pageSpeedService;
    protected $metricHistoryRunService;

    public function __construct(GooglePageSpeedService $pageSpeedService, MetricHistoryRunService $metricHistoryRunService)
    {
        $this->pageSpeedService = $pageSpeedService;
        $this->metricHistoryRunService = $metricHistoryRunService;
    }

    /**
     * Display the current metrics form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('current-metrics');
    }

    /**
     * Display the metrics history view.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        return view('metrics.history');
    }

    /**
     * Fetch metrics from Google PageSpeed Insights.
     *
     * @param FetchMetricsRequest $request
     * @return JsonResponse
     */
    public function fetchMetrics(FetchMetricsRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $url = $validated['url'];
        $categoryIds = $validated['categories'];
        $strategyId = $validated['strategy_id'];

        $strategyName = $this->getStrategyName($strategyId);

        try {
            $data = $this->pageSpeedService->fetchMetrics($url, $categoryIds, $strategyName);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->logError(Lang::get('messages.fetch_metrics_error'), $e, [
                'url' => $url,
                'categories' => $categoryIds,
                'strategy' => $strategyName,
            ]);
            return response()->json(['error' => Lang::get('messages.general_error')], 500);
        }
    }

    /**
     * Save metrics to the database.
     *
     * @param SaveMetricsRequest $request
     * @return JsonResponse
     */
    public function saveMetrics(SaveMetricsRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $metricHistoryRun = $this->metricHistoryRunService->createMetric($data);
            return response()->json(['success' => true, 'message' => Lang::get('messages.metrics_save_success')], 201);
        } catch (\Exception $e) {
            $this->logError(Lang::get('messages.metrics_save_error'), $e, ['data' => $data]);
            return response()->json(['error' => Lang::get('messages.metrics_save_error')], 500);
        }
    }

    /**
     * Get all metrics history.
     *
     * @return JsonResponse
     */
    public function getMetricsHistory(): JsonResponse
    {
        try {
            $metricsHistory = $this->metricHistoryRunService->getAllMetrics();
            return response()->json($metricsHistory);
        } catch (\Exception $e) {
            $this->logError(Lang::get('messages.general_error'), $e);
            return response()->json(['error' => Lang::get('messages.general_error')], 500);
        }
    }

    /**
     * Get strategy name by ID.
     *
     * @param int $strategyId
     * @return string
     */
    private function getStrategyName(int $strategyId): string
    {
        $strategy = Strategy::findOrFail($strategyId);
        return $strategy->name;
    }
}
