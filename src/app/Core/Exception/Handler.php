<?php

namespace App\Core\Exception;

use App\Core\Exception\Http\ForbiddenException;
use App\Core\Exception\Http\NotFoundException;
use App\Core\Exception\Http\UnauthorizedException;
use App\Core\Exception\Http\UnprocessableEntityHttpException;
use App\Core\Http\Response\Vo\JsonErrorDataVo;
use App\Core\Logger\SqlQueryLogger\SqlQueryLoggerInterface;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class Handler
 *
 * @package App\Core\Exception
 */
class Handler extends ExceptionHandler
{
    private const UNEXPECTED_EXCEPTION_STATUS_CODE = 500;

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception): void
    {
        parent::report($exception);

        if ($exception instanceof QueryException) {
            /** @var SqlQueryLoggerInterface $sqlQueryLogger */
            $sqlQueryLogger = app(SqlQueryLoggerInterface::class);
            $sqlQueryLogger->logException($exception);
            $sqlQueryLogger->write();
        }
    }

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        UnauthorizedException::class,
        ForbiddenException::class,
        NotFoundException::class,
        UnprocessableEntityHttpException::class,
    ];

    /**
     * Render an exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if (!$request->expectsJson()) {
            return parent::render($request, $e);
        }

        return $this->prepareJsonResponse($request, $this->prepareException($e));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $e
     * @return JsonResponse
     */
    protected function prepareJsonResponse($request, Exception $e): JsonResponse
    {
        $response = new JsonResponse();
        $e = $this->transformException($e);

        $code = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : self::UNEXPECTED_EXCEPTION_STATUS_CODE;

        $response->setStatusCode($code);

        // скрываем сообщения о 500 для пользователей, т.к. это системные сообщения, и знать они о них не должны.
        $errorData = [];
        if ($code !== self::UNEXPECTED_EXCEPTION_STATUS_CODE || config('app.return_stacktrace')) {
            $errorData = new JsonErrorDataVo($e, config('app.return_stacktrace'));
        }

        $response->setData($errorData);

        return $response;
    }

    /**
     * @param Exception $e
     *
     * @return Exception
     */
    private function transformException(\Exception $e): Exception
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return UnprocessableEntityHttpException::withHttpValidationErrorList($e->errors());
        }

        if ($e instanceof AuthenticationException) {
            return UnauthorizedException::newInstance();
        }

        return $e;
    }
}
