<?php

namespace App\Core\Logger\SqlQueryLogger;

use Illuminate\Database\QueryException;

/**
 * Interface SqlQueryLoggerInterface
 * @package App\Core\Logger\SqlQueryLogger
 */
interface SqlQueryLoggerInterface
{
    /**
     * @param QueryException $exception
     */
    public function logException(QueryException $exception): void;

    public function flush(): void;

    public function write(): void;
}
