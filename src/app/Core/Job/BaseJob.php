<?php

namespace App\Core\Job;

use App\Core\ConsoleOutput\Consolable;
use App\Core\Measurement\Measurable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\FailingJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Debug\Exception\FatalThrowableError;

/**
 * Class BaseJob
 * @package App\Core\Job
 * @property Job|JobContract $job
 */
abstract class BaseJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    use Consolable, Measurable;

    /**
     * Fail the job from the queue.
     *
     * @param \Throwable $e
     */
    public function fail(\Throwable $e = null)
    {
        if ($this->job && $this->job instanceof Job) {
            FailingJob::handle($this->job->getConnectionName(), $this->job, $e);
        }

        $jobData = null;
        if ($this->job) {
            $jobData = [
                'id' => $this->job->getJobId(),
                'class' => $this->job->payload()['displayName'] ?? null,
                'data' => $this->retrievePropertiesFromJob($this->job),
            ];
        }

        $exceptionData = null;
        if ($e) {
            $exceptionData = [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'stacktrace' => $e->getTrace(),
            ];
        }

        Log::error('Job failed', [
            'job' => $jobData,
            'exception' => $exceptionData,
        ]);

        if ($e !== null) {
            $this->printException($e);
        }
    }

    /**
     * @param int $delay
     * @param null $description
     */
    protected function releaseAndLog($delay = 0, $description = null): void
    {
        $this->info("Job timeout = {$delay} seconds" . ($description !== null ? " ({$description})" : ""));
        $this->release($delay);
    }

    /**
     * @param \Throwable $exception
     */
    protected function printException(\Throwable $exception): void
    {
        if ($exception instanceof \Throwable &&
            ! $exception instanceof \Exception) {
            $exception = new FatalThrowableError($exception);
        }

        /** @var ExceptionHandler $handler */
        $handler = app(ExceptionHandler::class);
        $handler->renderForConsole(new ConsoleOutput(OutputInterface::VERBOSITY_VERBOSE), $exception);
    }

    /**
     * @param JobContract $job
     * @return array
     */
    protected function retrievePropertiesFromJob(JobContract $job): array
    {
        if (!isset($job->payload()['data']['command'])) {
            return [];
        }

        return (array) unserialize($job->payload()['data']['command'], [static::class]);
    }
}
