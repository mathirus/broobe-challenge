<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\GooglePageSpeedException;
use App\Traits\HandlesLogging;
use App\Models\Category;
use Illuminate\Support\Facades\Lang;

class GooglePageSpeedService
{
    use HandlesLogging;

    protected $client;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function fetchMetrics(string $url, array $categoryIds, string $strategy): array
    {
        $endpoint = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
        $requestedCategories = Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
        $allCategories = Category::pluck('name')->toArray();
        $query = $this->buildQuery($url, $requestedCategories, $strategy);

        try {
            $response = $this->client->get($endpoint . '?' . $query);
            $data = json_decode($response->getBody(), true);
            $filteredData = $this->filterResponse($data, $strategy, $allCategories);
            return $filteredData;
        } catch (RequestException $e) {
            $this->logError(Lang::get('messages.fetch_metrics_error'), $e, [
                'url' => $url,
                'categories' => $requestedCategories,
                'strategy' => $strategy,
            ]);
            throw new GooglePageSpeedException(Lang::get('messages.fetch_metrics_error'), 0, $e);
        }
    }

    private function buildQuery(string $url, array $categories, string $strategy): string
    {
        $params = [
            'url' => $url,
            'key' => $this->apiKey,
            'strategy' => $strategy,
        ];

        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        foreach ($categories as $category) {
            $query .= '&category=' . urlencode(strtolower(str_replace('_', '-', $category)));
        }

        return $query;
    }

    private function filterResponse(array $data, string $strategy, array $allCategories): array
    {
        $filteredData = [
            'id' => $data['id'] ?? null,
            'strategy' => $strategy,
            'categories' => [],
        ];

        $apiCategories = array_change_key_case($data['lighthouseResult']['categories'] ?? [], CASE_LOWER);

        foreach ($allCategories as $category) {
            $categoryLower = strtolower(str_replace('_', '-', $category));
            $filteredData['categories'][$category] = [
                'id' => strtoupper($category),
                'title' => ucfirst(str_replace('_', ' ', strtolower($category))),
                'score' => $apiCategories[$categoryLower]['score'] ?? null,
            ];
        }

        return $filteredData;
    }
}
