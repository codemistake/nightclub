<?php

namespace App\Core\Mail\Provider;

use App\Core\Mail\MailClientInterface;
use App\Core\Mail\SwiftMailerMailClient;
use Illuminate\Support\ServiceProvider;

/**
 * Class MailServiceProvider
 *
 * @package App\Core\Mail\Provider
 */
class MailServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @return array
     */
    public function provides()
    {
        return [
            MailClientInterface::class,
        ];
    }

    public function register()
    {
        $this->app->singleton(MailClientInterface::class, function () {
             return new SwiftMailerMailClient(
                env('MAIL_HOST', 'mailcatcher'),
                env('MAIL_PORT', '25'),
                env('MAIL_USERNAME', ''),
                env('MAIL_PASSWORD', '')
             );
        });
    }
}
