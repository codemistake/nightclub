<?php

namespace App\Core\Logger\SqlQueryLogger;

use Illuminate\Database\QueryException;

/**
 * Class DummySqlQueryLogger
 * @package App\Core\Logger\SqlQueryLogger
 */
class DummySqlQueryLogger implements SqlQueryLoggerInterface
{
    public function enable(): void
    {
        // do nothing
    }

    /**
     * @param QueryException $exception
     */
    public function logException(QueryException $exception): void
    {
        // do nothing
    }

    public function flush(): void
    {
        // do nothing
    }

    public function write(): void
    {
        // do nothing
    }
}
