<?php

namespace App\Services;

use App\Jobs\BackgroundJobRunner;
use Illuminate\Support\Facades\Log;

namespace App\Services;

use App\Jobs\BackgroundJobRunner;
use Illuminate\Support\Facades\Log;

class JobExecutorService
{
    public function executeJob(string $className, string $methodName, array $parameters = [], string $queue = 'default', string $priority = 'high')
    {
        try {
            // Define job priority queues
            $priorityQueue = $this->getPriorityQueue($priority);

            Log::info("Dispatching job: {$className}::{$methodName} with parameters: " . json_encode($parameters));

            // Dispatch the job to the Redis queue with the specified priority
            dispatch(new BackgroundJobRunner($className, $methodName, $parameters))->onQueue($priorityQueue);

            Log::info("Job dispatched successfully with priority: {$priorityQueue}.");
        } catch (\Exception $e) {
            Log::error("Failed to dispatch job: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Get the priority queue name.
     *
     * @param string $priority
     * @return string
     */
    protected function getPriorityQueue(string $priority): string
    {
        switch ($priority) {
            case 'low':
                return 'low';
            case 'medium':
                return 'medium';
            case 'high':
            default:
                return 'high';
        }
    }
}

