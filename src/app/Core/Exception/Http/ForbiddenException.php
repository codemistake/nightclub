<?php

namespace App\Core\Exception\Http;

use App\Core\Exception\ExceptionCodes;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class ForbiddenException
 * @package App\Core\Exception\Http
 */
class ForbiddenException extends AccessDeniedHttpException implements ExceptionDataInterface
{
    use ExceptionDataTrait;

    /**
     * @return ForbiddenException
     */
    public static function newInstance(): self
    {
        return (new static('Unauthorized'))->setData(null);
    }

    /**
     * @param string $requestField
     * @param string $fieldName
     *
     * @return ForbiddenException
     */
    public static function withFieldAccess(string $requestField, string $fieldName): self
    {
        return (new static("No access to field [{$fieldName}]"))
            ->setData([$requestField => "No access to field [{$fieldName}]"]);
    }
}
