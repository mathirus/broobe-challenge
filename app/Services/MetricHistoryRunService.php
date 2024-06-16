<?php

namespace App\Services;

use App\Models\MetricHistoryRun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MetricHistoryRunService
{

    public function createMetric(array $data): MetricHistoryRun
    {
        try {
            $metricHistoryRun = MetricHistoryRun::create($data);
            return $metricHistoryRun;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findMetric(int $id): ?MetricHistoryRun
    {
        try {
            return MetricHistoryRun::find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getAllMetrics()
    {
        return MetricHistoryRun::with('strategy')->get()->map(function ($metric) {
            return [
                'url' => $metric->url,
                'strategy_name' => $metric->strategy->name,
                'accessibility_metric' => $metric->accessibility_metric,
                'pwa_metric' => $metric->pwa_metric,
                'performance_metric' => $metric->performance_metric,
                'seo_metric' => $metric->seo_metric,
                'best_practices_metric' => $metric->best_practices_metric,
                'created_at' => $metric->created_at->format('Y-m-d H:i:s'),
            ];
        });

    }
}
