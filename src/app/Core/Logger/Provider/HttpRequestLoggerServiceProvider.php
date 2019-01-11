<?php

namespace App\Core\Logger\Provider;

use App\Core\Logger\HttpRequestLogger\Middleware\HttpRequestLoggerMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

/**
 * Class HttpRequestLoggerServiceProvider
 * @package App\Core\Logger\HttpRequestLogger\Provider
 */
class HttpRequestLoggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('logging.req_resp', false)) {
            $this->app->make(Kernel::class)->prependMiddleware(HttpRequestLoggerMiddleware::class);
        }
    }
}
