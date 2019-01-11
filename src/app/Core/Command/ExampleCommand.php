<?php

namespace App\Core\Command;

use Illuminate\Foundation\Inspiring;

/**
 * Class ExampleCommand
 * @package App\Core\Command
 */
class ExampleCommand extends BaseCommand
{
    const SIGNATURE = 'example';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Example command';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle(): void
    {
        $this->beforeHandle();

        try {
            $this->work();
        } finally {
            $this->afterHandle();
        }
    }

    protected function work(): void
    {
        $this->info(Inspiring::quote());
    }
}
