<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (config('log.cron')) {
            $dir = logs_path(date('Y' . DIRECTORY_SEPARATOR . 'm' . DIRECTORY_SEPARATOR . 'd'));
            $location = $dir . DIRECTORY_SEPARATOR . 'cron.log';
            $append = true;

            $this->tryCreateLogDir($dir, $location);
        } else {
            $location = '/dev/null';
            $append = false;
        }
    }

    /**
     * @param $dir
     * @param $filepath
     */
    protected function tryCreateLogDir($dir, $filepath): void
    {
        /** @var \Illuminate\Filesystem\Filesystem $filesystem */
        $filesystem = app('files');
        if (!$filesystem->exists($dir)) {
            $oldUmask = umask();
            @umask(0);
            @$filesystem->makeDirectory($dir, 0775, true);
            @umask($oldUmask);
        }

        if (!$filesystem->exists($filepath)) {
            $filesystem->put($filepath, '');
            $oldUmask = umask();
            @umask(0);
            @chmod($filepath, 0775);
            @umask($oldUmask);
        }
    }
}
