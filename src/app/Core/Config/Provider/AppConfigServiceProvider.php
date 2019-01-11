<?php

namespace App\Core\Config\Provider;

use App\Core\Config\AppConfig;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppConfigServiceProvider
 * @package App\Core\Provider
 */
class AppConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AppConfig::class, function () {
            return new AppConfig(config('app.timezone'));
        });
    }
}
