```markdown
# Laravel Background Job Runner with Redis and Job Priority

This project demonstrates a custom background job runner system for Laravel using Redis as the queue driver. Jobs can be dispatched with priority levels (`high`, `medium`, `low`) and are processed by a Redis queue.

## Features:
- **Job Priority**: Support for job priority levels (`high`, `medium`, `low`).
- **Custom Job Dispatcher**: Jobs are dispatched using a custom job runner.
- **Redis Queue Driver**: Uses Redis as the queue driver.
- **Artisan Command**: A custom artisan command for dispatching jobs with priority.
- **Web Route**: A simple route to dispatch jobs with priority via HTTP.

## Installation

1. Install dependencies:

    ```bash
    composer install
    ```

2. Set up your `.env` file with the following Redis configuration:

    ```env
    QUEUE_CONNECTION=redis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    ```

3. Start Redis (if not already running). You can start Redis via Docker:

    ```bash
    docker run --name redis -p 6379:6379 -d redis
    ```

4. Run the migrations if needed:

    ```bash
    php artisan migrate
    ```

5. Start the queue worker:

    ```bash
    php artisan queue:work redis
    ```

## Usage

### Dispatch a Job via HTTP Route

You can dispatch a background job via an HTTP route with a specific priority.

**Example URL:**

```
GET /run-job?priority=high
```

This will dispatch the `ExampleService::exampleMethod` job with a high priority.

### Dispatch a Job via Artisan Command

You can also dispatch jobs using the Artisan command line with priority.

**Example Command:**

```bash
php artisan job:dispatch App\Services\ExampleService exampleMethod --priority=medium
```

This will dispatch the job `App\Services\ExampleService::exampleMethod` to the `medium` priority queue.

**Command Syntax**:

```bash
php artisan job:dispatch {className} {methodName} --priority={priority}
```

- `className`: The fully qualified name of the class that contains the method you want to run as a background job.
- `methodName`: The name of the method you want to run from the class.
- `--priority`: The priority of the job (`high`, `medium`, or `low`).

#### Example 1: Dispatch Job with `high` Priority

```bash
php artisan job:dispatch App\Services\ExampleService exampleMethod --priority=high
```

This command will dispatch the job `App\Services\ExampleService::exampleMethod` to the `high` priority queue.

#### Example 2: Dispatch Job with `medium` Priority

```bash
php artisan job:dispatch App\Services\ExampleService exampleMethod --priority=medium
```

This will dispatch the job with `medium` priority.

#### Example 3: Dispatch Job with `low` Priority

```bash
php artisan job:dispatch App\Services\ExampleService exampleMethod --priority=low
```

This will dispatch the job with `low` priority.

### Available Priorities

- `high` (default)
- `medium`
- `low`

Jobs in the higher-priority queues will be processed before those in lower-priority queues.

## Troubleshooting

- Ensure Redis is running.
- If jobs are not processing, check the Redis queue status with `redis-cli` or use Laravel Horizon to monitor job processing.

## Horizon (Optional)

For a web-based interface to monitor queues, you can install [Laravel Horizon](https://laravel.com/docs/9.x/horizon).

To install Horizon:

```bash
composer require laravel/horizon
php artisan horizon:install
php artisan horizon
```

Then, access Horizon at:

```
http://your-app.test/horizon
```

This dashboard will allow you to monitor job statuses, retry failed jobs, and see which jobs are running.

## Conclusion

This project demonstrates how to create a custom job runner system in Laravel with Redis and job priority support, offering flexibility in background job processing.
```

### Key Additions:
- **Examples of Artisan Command Usage**: Detailed examples of running the `php artisan job:dispatch` command with `high`, `medium`, and `low` priorities.
- **Command Syntax**: Clear explanation of the required parameters for the Artisan command (`className`, `methodName`, and `--priority`).
- **Horizon Integration**: Instructions for setting up and using Laravel Horizon to monitor jobs via a web-based dashboard.

This `README.md` now fully explains how to use the custom background job runner, including the Artisan command, HTTP route, and job priority handling.
