<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ExampleService
{
    /**
     * Example method that will be executed as a background job.
     *
     * @param string $param
     * @return void
     */
    public function exampleMethod($param)
    {
        // Simulate a background task (e.g., processing or logging)
        Log::info("ExampleService::exampleMethod executed with parameter: $param");
    }
}
