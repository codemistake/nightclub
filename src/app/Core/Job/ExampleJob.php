<?php

namespace App\Core\Job;

use Illuminate\Foundation\Inspiring;

/**
 * Class ExampleJob
 * @package App\Core\Job
 */
class ExampleJob extends BaseJob
{
    /**
     * Execute the job.
     * @throws \Throwable
     */
    public function handle(): void
    {
        $this->beforeHandle();

        try {
            $this->work();
        } catch (\Throwable $e) {
            $this->fail($e);
            throw $e;
        } finally {
            $this->afterHandle();
        }
    }

    protected function work(): void
    {
        $this->info(Inspiring::quote());
    }
}
