<?php

namespace App\Module;

use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleServiceProvider
 * @package App\Module
 */
class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem();

        foreach ($filesystem->directories(__DIR__) as $directory) {
            $providersDir = $directory . '/Provider/';
            if (file_exists($providersDir)) {
                foreach (new \DirectoryIterator($providersDir) as $info) {
                    if (!$info->isFile()) {
                        continue;
                    }
                    if (is_readable($info->getPathname())) {
                        $providerClass = 'App\Module\\' . last(explode('/', $directory)) . '\Provider\\' . $info->getBasename('.php');
                        $this->app->register($providerClass);
                    }
                }
            }
        }
    }
}
