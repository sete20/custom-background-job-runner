<?php

namespace App\Helpers;

use App\Services\JobExecutorService;
use Illuminate\Support\Facades\Log;
class JobHelper
{
    /**
     * Runs the background job with the given parameters.
     *
     * @param string $className
     * @param string $methodName
     * @param array $parameters
     * @param string $queue
     * @return void
     */
    public static function runBackgroundJob(string $className, string $methodName, array $parameters = [], string $queue = 'default')
    {
        try {
            $jobExecutor = app(JobExecutorService::class);
            $jobExecutor->executeJob($className, $methodName, $parameters, $queue);
        } catch (\Exception $e) {
            Log::error("Failed to execute job via JobHelper: {$e->getMessage()}");
        }
    }
}
