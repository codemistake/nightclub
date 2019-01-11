<?php

namespace App\Core\Logger\SqlQueryLogger\Middleware;

use App\Core\Logger\SqlQueryLogger\SqlQueryLoggerInterface;
use Closure;

/**
 * Class SqlQueryLoggerMiddleware
 * @package App\Core\Logger\SqlQueryLogger\Middleware
 */
class SqlQueryLoggerMiddleware
{
    /** @var SqlQueryLoggerInterface */
    private $sqlQueryLogger;

    /**
     * LogDatabaseQueriesMiddleware constructor.
     * @param SqlQueryLoggerInterface $sqlQueryLogger
     */
    public function __construct(SqlQueryLoggerInterface $sqlQueryLogger)
    {
        $this->sqlQueryLogger = $sqlQueryLogger;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $this->sqlQueryLogger->write();

        return $response;
    }
}
