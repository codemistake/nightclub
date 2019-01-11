<?php

namespace App\Core\Validation\Provider;

use Illuminate\Support\ServiceProvider;
use App\Component\Core\Validation\Validator;
use App\Component\Core\Validation\ValidatorInterface;

/**
 * Class ValidationServiceProvider
 * @package App\Core\Validation\Provider
 */
class ValidationServiceProvider extends ServiceProvider
{
    public $defer = true;

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            ValidatorInterface::class,
        ];
    }

    public function boot()
    {
        $this->app->singleton(ValidatorInterface::class, function () {
            return new Validator();
        });
    }
}
