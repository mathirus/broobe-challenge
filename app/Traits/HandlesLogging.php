<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait HandlesLogging
{
    /**
     * Log an error with additional context.
     *
     * @param string $message
     * @param \Exception $e
     * @param array $context
     * @return void
     */
    public function logError(string $message, \Exception $e, array $context = []): void
    {
        Log::error($message . ': ' . $e->getMessage(), array_merge($context, ['exception' => $e]));
    }
}
