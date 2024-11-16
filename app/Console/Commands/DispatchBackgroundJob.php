<?php

namespace App\Console\Commands;

use App\Services\JobExecutorService;
use Illuminate\Console\Command;
use App\Helpers\JobHelper;
class DispatchBackgroundJob extends Command
{
    protected $signature = 'job:dispatch {className} {methodName} {--priority=default} {--param=}';

    protected $description = 'Dispatch a background job with optional parameters and priority.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $className = $this->argument('className');
        $methodName = $this->argument('methodName');
        $priority = $this->option('priority');
        $param = $this->option('param'); // Capture the 'param' option

        if ($param) {
            // Pass the parameter as an array to the job helper
            JobHelper::runBackgroundJob($className, $methodName, [$param], $priority);
            $this->info("Job dispatched to {$className}::{$methodName} with priority {$priority}.");
        } else {
            $this->error('No parameter provided for the job.');
        }
    }
}
