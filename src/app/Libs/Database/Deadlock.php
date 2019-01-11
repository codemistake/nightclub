<?php

namespace App\Libs\Database;

use Illuminate\Database\DetectsDeadlocks;

class Deadlock
{
    use DetectsDeadlocks;

    private static $instance;

    /**
     * Retry an operation a given number of times in case of deadlock.
     * Based on laravel helper "retry()"
     *
     * @param  callable $callback
     * @param  int $times
     * @param  int $sleep
     * @return mixed
     *
     * @throws \Exception
     */
    public static function avoid(callable $callback, $times = 5, $sleep = 1000)
    {
        // Для вызова метода из Trait
        if (self::$instance === null) {
            self::$instance = new self();
        }

        $times--;

        beginning:
        try {
            return $callback();
        } catch (\Exception $e) {
            if (!$times || !self::$instance->causedByDeadlock($e)) {
                throw $e;
            }

            $times--;

            if ($sleep) {
                usleep($sleep * 1000);
            }

            goto beginning;
        }
    }
}