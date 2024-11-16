<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class BackgroundJobRunner implements ShouldQueue
{
        use Dispatchable, Queueable;

        protected $className;
        protected $methodName;
        protected $parameters;

        /**
         * Create a new job instance.
         *
         * @param string $className
         * @param string $methodName
         * @param array $parameters
         */
        public function __construct(string $className, string $methodName, array $parameters = [])
        {
            $this->className = $className;
            $this->methodName = $methodName;
            $this->parameters = $parameters;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            try {
                // Check if parameters are passed correctly
                if (empty($this->parameters)) {
                    Log::error("No parameters were passed to the job.");
                    return;
                }

                // Instantiate the class and call the method with parameters
                $class = app($this->className);
                if (method_exists($class, $this->methodName)) {
                    call_user_func_array([$class, $this->methodName], $this->parameters);
                    Log::info("Job executed: {$this->className}::{$this->methodName} with parameters: " . implode(", ", $this->parameters));
                } else {
                    Log::error("Method {$this->methodName} does not exist on class {$this->className}");
                }
            } catch (\Exception $e) {
                Log::error("Job execution failed: {$e->getMessage()}");
            }
        }
    }
