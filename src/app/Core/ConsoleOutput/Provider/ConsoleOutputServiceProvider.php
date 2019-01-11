<?php

namespace App\Core\ConsoleOutput\Provider;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleOutputServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('consoleOutput', function(){
            $formatter = new OutputFormatter();
            $formatter->setStyle('warning', new OutputFormatterStyle('yellow'));

            $verbosity = env('APP_ENV') === 'testing'
                ? ConsoleOutput::VERBOSITY_QUIET
                : ConsoleOutput::VERBOSITY_NORMAL;

            return new ConsoleOutput($verbosity, true, $formatter);
        });
    }
}
